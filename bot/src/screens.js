import { InlineKeyboard } from 'grammy';
import { t } from './i18n.js';
import * as api from './api.js';
import {
    mainMenu, backMenu, docsMenu, plansMenu, dashboardMenu,
    money, formatDate, periodLabel, escapeHtml,
} from './ui.js';

const PLATFORM_LABELS = {
    windows: 'Windows', macos: 'macOS', linux: 'Linux', android: 'Android',
    ios: 'iPhone / iPad', androidtv: 'Android TV', smarttv: 'Smart TV', router: 'Router',
};

export function mainScreen(session) {
    const lang = session.lang;
    const loggedIn = Boolean(session.token);
    const text = loggedIn
        ? t(lang, 'welcome_back', { name: escapeHtml(session.name || '') })
        : t(lang, 'welcome');
    return { text, keyboard: mainMenu(lang, loggedIn) };
}

export async function accountScreen(session) {
    const lang = session.lang;
    const me = await api.getMe(session.token);

    const lines = [t(lang, 'account_title'), '', t(lang, 'acc_email', { email: escapeHtml(me.email) })];

    if (me.subscription) {
        lines.push(
            t(lang, 'acc_plan', { plan: escapeHtml(me.subscription.plan) }),
            t(lang, 'acc_status', { status: t(lang, 'status_' + me.subscription.status) }),
            t(lang, 'acc_until', { date: formatDate(me.subscription.ends_at, lang) }),
            t(lang, 'acc_days', { days: me.subscription.days_left }),
        );
    } else {
        lines.push('', t(lang, 'acc_no_sub'));
    }

    lines.push('', t(lang, 'acc_balance', { balance: money(me.balance) }));

    return { text: lines.join('\n'), keyboard: dashboardMenu(lang) };
}

export async function connectionsScreen(session) {
    const lang = session.lang;
    const connections = await api.getConnections(session.token);

    if (!connections.length) {
        return { text: t(lang, 'connections_title') + '\n\n' + t(lang, 'conn_none'), keyboard: backMenu(lang) };
    }

    const kb = new InlineKeyboard();
    connections.forEach((c) => kb.text(`🔌 ${c.name}`, `conn:${c.uuid}`).row());
    kb.text(t(lang, 'btn_back'), 'nav:main');

    return { text: t(lang, 'connections_title') + '\n\n' + t(lang, 'conn_pick'), keyboard: kb };
}

export async function connectionDetailScreen(session, uuid) {
    const lang = session.lang;
    const c = await api.getConnection(session.token, uuid);

    const lines = [
        `🔌 <b>${escapeHtml(c.name)}</b>`,
        '',
        t(lang, 'conn_region', { region: escapeHtml(c.region || '—') }),
        t(lang, 'conn_status', { status: t(lang, 'status_' + c.status) }),
        '',
        t(lang, 'conn_link', { link: escapeHtml(c.config_link || c.access_token) }),
    ];

    if (c.subscription_url) {
        lines.push('', t(lang, 'conn_sub', { sub: escapeHtml(c.subscription_url) }));
    }

    lines.push('', t(lang, 'conn_copy_hint'));

    const kb = new InlineKeyboard().text(t(lang, 'btn_back'), 'nav:connections');
    return { text: lines.join('\n'), keyboard: kb };
}

export async function devicesScreen(session) {
    const lang = session.lang;
    const devices = await api.getDevices(session.token);

    if (!devices.length) {
        return { text: t(lang, 'devices_title') + '\n\n' + t(lang, 'dev_none'), keyboard: backMenu(lang) };
    }

    const lines = [t(lang, 'devices_title'), ''];
    devices.forEach((d) => {
        const label = PLATFORM_LABELS[d.platform] || d.platform;
        lines.push(`• <b>${escapeHtml(d.name)}</b> — ${escapeHtml(label)}`);
    });

    return { text: lines.join('\n'), keyboard: backMenu(lang) };
}

export async function plansScreen(session) {
    const lang = session.lang;
    const plans = await api.getPlans();

    const lines = [t(lang, 'plans_title'), ''];
    plans.forEach((p) => {
        const star = p.is_popular ? ' ' + t(lang, 'plan_popular') : '';
        lines.push(`💼 <b>${escapeHtml(p.name)}</b>${star}`);
        lines.push(`   ${money(p.price)} ₽ / ${periodLabel(lang, p.period)} · ${t(lang, 'plan_devices', { count: p.device_limit })}`);
        lines.push('');
    });
    lines.push('<i>' + t(lang, 'plans_hint') + '</i>');

    return { text: lines.join('\n'), keyboard: plansMenu(lang) };
}

export async function referralsScreen(session) {
    const lang = session.lang;
    const me = await api.getMe(session.token);
    const r = me.referral || {};

    const lines = [
        t(lang, 'referrals_title'),
        '',
        t(lang, 'ref_invited', { count: r.invited ?? 0 }),
        t(lang, 'ref_balance', { balance: money(me.balance) }),
        t(lang, 'ref_code', { code: escapeHtml(r.code || '—') }),
        '',
        t(lang, 'ref_link', { link: escapeHtml(r.link || '') }),
        '',
        '<i>' + t(lang, 'ref_hint') + '</i>',
    ];

    return { text: lines.join('\n'), keyboard: backMenu(lang) };
}

export function docsScreen(session) {
    return { text: t(session.lang, 'docs_title'), keyboard: docsMenu(session.lang) };
}

export async function supportScreen(session) {
    const lang = session.lang;
    let meta = {};
    try {
        meta = await api.getMeta();
    } catch {
        // fall back to text only
    }

    const lines = [t(lang, 'support_title'), '', t(lang, 'support_text'), ''];
    if (meta.support_email) lines.push(t(lang, 'support_email', { email: escapeHtml(meta.support_email) }));
    if (meta.support_telegram) lines.push(t(lang, 'support_tg', { tg: escapeHtml(meta.support_telegram) }));

    return { text: lines.join('\n'), keyboard: backMenu(lang) };
}
