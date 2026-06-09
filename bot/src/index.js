import { Bot, session, GrammyError, HttpError } from 'grammy';
import { HttpsProxyAgent } from 'https-proxy-agent';
import { config } from './config.js';
import { FileAdapter } from './storage.js';
import { t } from './i18n.js';
import * as api from './api.js';
import { cancelMenu, mainMenu } from './ui.js';
import * as screens from './screens.js';

// grammY on Node uses node-fetch, which proxies via an `agent` (not an undici
// dispatcher). Applied only when a proxy is configured — inert on a normal server.
const proxyUrl = process.env.BOT_PROXY || process.env.HTTPS_PROXY || process.env.ALL_PROXY;
const botConfig = {};
if (proxyUrl) {
    botConfig.client = { baseFetchConfig: { agent: new HttpsProxyAgent(proxyUrl) } };
    console.log('[net] Telegram API via proxy:', proxyUrl);
}

const bot = new Bot(config.botToken, botConfig);
const storage = new FileAdapter(config.sessionFile);

const initial = () => ({
    token: null,
    name: null,
    lang: config.defaultLang,
    step: null,
    tmpName: null,
    tmpEmail: null,
});

bot.use(session({ initial, storage }));

const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

/** Send a screen as a new message, or edit the message behind a callback. */
async function show(ctx, screen, { edit = false } = {}) {
    const options = {
        parse_mode: 'HTML',
        reply_markup: screen.keyboard,
        link_preview_options: { is_disabled: true },
    };

    if (edit && ctx.callbackQuery) {
        try {
            await ctx.editMessageText(screen.text, options);
            return;
        } catch {
            // message unchanged or too old — fall through to a fresh reply
        }
    }
    await ctx.reply(screen.text, options);
}

const showMain = (ctx, edit) => show(ctx, screens.mainScreen(ctx.session), { edit });

async function startLogin(ctx, edit) {
    ctx.session.step = 'email';
    ctx.session.tmpEmail = null;
    await show(ctx, { text: t(ctx.session.lang, 'login_intro'), keyboard: cancelMenu(ctx.session.lang) }, { edit });
}

async function startRegister(ctx, edit) {
    const lang = ctx.session.lang;

    // One Telegram = one account. Block a second sign-up up front.
    if (!ctx.session.token) {
        try {
            const existing = await api.telegramLogin(ctx.from.id);
            if (existing) {
                ctx.session.token = existing.token;
                ctx.session.name = existing.user.name;
            }
        } catch { /* ignore — allow registration as a new user */ }
    }

    if (ctx.session.token) {
        ctx.session.step = null;
        return show(ctx, {
            text: t(lang, 'reg_already_exists', { name: ctx.session.name || '' }),
            keyboard: mainMenu(lang, true),
        }, { edit });
    }

    ctx.session.step = 'reg_name';
    ctx.session.tmpName = null;
    ctx.session.tmpEmail = null;
    await show(ctx, { text: t(lang, 'reg_intro'), keyboard: cancelMenu(lang) }, { edit });
}

async function doLogout(ctx) {
    if (ctx.session.token) await api.logout(ctx.session.token);
    ctx.session.token = null;
    ctx.session.name = null;
    ctx.session.step = null;
}

/* ------------------------------ Commands ------------------------------ */

bot.command(['start', 'menu', 'help'], async (ctx) => {
    ctx.session.step = null;
    // Auto-recognise a returning Telegram user (e.g. after the bot restarted).
    if (!ctx.session.token) {
        try {
            const res = await api.telegramLogin(ctx.from.id);
            if (res) {
                ctx.session.token = res.token;
                ctx.session.name = res.user.name;
            }
        } catch { /* ignore — fall back to guest menu */ }
    }
    await showMain(ctx, false);
});

bot.command('register', (ctx) => startRegister(ctx, false));

bot.command('login', (ctx) => startLogin(ctx, false));

bot.command('logout', async (ctx) => {
    await doLogout(ctx);
    await ctx.reply(t(ctx.session.lang, 'logout_ok'), { parse_mode: 'HTML' });
    await showMain(ctx, false);
});

/* --------------------------- Callback router -------------------------- */

const guarded = {
    'nav:account': screens.accountScreen,
    'nav:connections': screens.connectionsScreen,
    'nav:devices': screens.devicesScreen,
    'nav:referrals': screens.referralsScreen,
};

bot.on('callback_query:data', async (ctx) => {
    const data = ctx.callbackQuery.data;
    const lang = ctx.session.lang;
    await ctx.answerCallbackQuery().catch(() => {});

    try {
        if (data === 'nav:main' || data === 'act:cancel') {
            ctx.session.step = null;
            return showMain(ctx, true);
        }

        if (data === 'act:lang') {
            ctx.session.lang = lang === 'ru' ? 'en' : 'ru';
            return showMain(ctx, true);
        }

        if (data === 'act:register') return startRegister(ctx, true);

        if (data === 'act:login') return startLogin(ctx, true);

        if (data === 'act:logout') {
            await doLogout(ctx);
            return showMain(ctx, true);
        }

        // Public sections
        if (data === 'nav:plans') return show(ctx, await screens.plansScreen(ctx.session), { edit: true });
        if (data === 'nav:docs') return show(ctx, screens.docsScreen(ctx.session), { edit: true });
        if (data === 'nav:support') return show(ctx, await screens.supportScreen(ctx.session), { edit: true });

        // Auth-required sections
        if (guarded[data]) {
            if (!ctx.session.token) return startLogin(ctx, true);
            return show(ctx, await guarded[data](ctx.session), { edit: true });
        }

        if (data.startsWith('conn:')) {
            if (!ctx.session.token) return startLogin(ctx, true);
            return show(ctx, await screens.connectionDetailScreen(ctx.session, data.slice(5)), { edit: true });
        }
    } catch (error) {
        if (api.isAuthError(error)) {
            ctx.session.token = null;
            ctx.session.name = null;
            return startLogin(ctx, true);
        }
        console.error('[callback]', error.message);
        await ctx.reply(t(lang, 'error'));
    }
});

/* ------------------------ Login flow (text msgs) --------------------- */

bot.on('message:text', async (ctx) => {
    const lang = ctx.session.lang;
    const step = ctx.session.step;
    if (!step) return;

    const value = ctx.message.text.trim();

    // ---- Registration flow ----
    if (step === 'reg_name') {
        if (value.length < 2) {
            return ctx.reply(t(lang, 'reg_intro'), { parse_mode: 'HTML', reply_markup: cancelMenu(lang) });
        }
        ctx.session.tmpName = value.slice(0, 120);
        ctx.session.step = 'reg_email';
        return ctx.reply(t(lang, 'reg_ask_email'), { parse_mode: 'HTML', reply_markup: cancelMenu(lang) });
    }

    if (step === 'reg_email') {
        if (!EMAIL_RE.test(value)) {
            return ctx.reply(t(lang, 'bad_email'), { reply_markup: cancelMenu(lang) });
        }
        ctx.session.tmpEmail = value;
        ctx.session.step = 'reg_password';
        return ctx.reply(t(lang, 'reg_ask_password'), { parse_mode: 'HTML', reply_markup: cancelMenu(lang) });
    }

    if (step === 'reg_password') {
        const password = value;
        await ctx.deleteMessage().catch(() => {}); // scrub the password message
        if (password.length < 8) {
            return ctx.reply(t(lang, 'reg_password_short'), { reply_markup: cancelMenu(lang) });
        }

        const name = ctx.session.tmpName;
        const email = ctx.session.tmpEmail;
        ctx.session.step = null;
        ctx.session.tmpName = null;
        ctx.session.tmpEmail = null;

        try {
            const { token, user } = await api.register({
                name,
                email,
                password,
                telegramId: String(ctx.from.id),
                locale: lang,
            });
            ctx.session.token = token;
            ctx.session.name = user.name;
            await ctx.reply(t(lang, 'reg_success', { name: user.name }), { parse_mode: 'HTML' });
            return showMain(ctx, false);
        } catch (error) {
            const status = error.response?.status;
            const errors = error.response?.data?.errors || {};
            console.error('[register]', status, error.message);

            // This Telegram already has an account → log them back in transparently.
            if (status === 422 && errors.telegram_id) {
                try {
                    const res = await api.telegramLogin(ctx.from.id);
                    if (res) {
                        ctx.session.token = res.token;
                        ctx.session.name = res.user.name;
                        await ctx.reply(t(lang, 'login_ok', { name: res.user.name }), { parse_mode: 'HTML' });
                        return showMain(ctx, false);
                    }
                } catch { /* fall through to message */ }
                return ctx.reply(t(lang, 'reg_telegram_linked'), { parse_mode: 'HTML' });
            }

            if (status === 422 && errors.email) {
                ctx.session.step = 'reg_email';
                return ctx.reply(t(lang, 'reg_email_taken'), { parse_mode: 'HTML', reply_markup: cancelMenu(lang) });
            }
            return ctx.reply(t(lang, 'reg_failed'), { parse_mode: 'HTML' });
        }
    }

    if (step === 'email') {
        if (!EMAIL_RE.test(value)) {
            return ctx.reply(t(lang, 'bad_email'), { reply_markup: cancelMenu(lang) });
        }
        ctx.session.tmpEmail = value;
        ctx.session.step = 'password';
        return ctx.reply(t(lang, 'ask_password'), { parse_mode: 'HTML', reply_markup: cancelMenu(lang) });
    }

    if (step === 'password') {
        const email = ctx.session.tmpEmail;
        await ctx.deleteMessage().catch(() => {}); // scrub the password message
        ctx.session.step = null;
        ctx.session.tmpEmail = null;

        try {
            const { token, user } = await api.login(email, value, String(ctx.from.id));
            ctx.session.token = token;
            ctx.session.name = user.name;
            await ctx.reply(t(lang, 'login_ok', { name: user.name }), { parse_mode: 'HTML' });
            return showMain(ctx, false);
        } catch (error) {
            console.error('[login]', error.response?.status, error.message);
            return ctx.reply(t(lang, 'login_fail'), { parse_mode: 'HTML' });
        }
    }
});

/* ------------------------------- Errors ------------------------------ */

bot.catch((err) => {
    const e = err.error;
    if (e instanceof GrammyError) console.error('[grammy]', e.description);
    else if (e instanceof HttpError) console.error('[telegram-http]', e);
    else console.error('[error]', e);
});

/* ------------------------------ Bootstrap ---------------------------- */

async function bootstrap() {
    await bot.api.setMyCommands([
        { command: 'start', description: 'Главное меню / Main menu' },
        { command: 'register', description: 'Создать аккаунт / Sign up' },
        { command: 'login', description: 'Войти / Log in' },
        { command: 'logout', description: 'Выйти / Log out' },
        { command: 'menu', description: 'Меню / Menu' },
        { command: 'help', description: 'Помощь / Help' },
    ]);

    console.log('🤖 Flux Telegram bot is running.');
    console.log('   API:', config.apiBaseUrl);
    console.log('   Site:', config.siteUrl);

    await bot.start({ onStart: (info) => console.log(`   Logged in as @${info.username}`) });
}

process.once('SIGINT', () => bot.stop());
process.once('SIGTERM', () => bot.stop());

bootstrap().catch((error) => {
    console.error('[fatal]', error.message);
    process.exit(1);
});
