import { InlineKeyboard } from 'grammy';
import { t } from './i18n.js';
import { config } from './config.js';

/* ----------------------------- Formatting ----------------------------- */

export function escapeHtml(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;');
}

export function money(amount) {
    return new Intl.NumberFormat('ru-RU').format(Number(amount) || 0);
}

export function formatDate(iso, lang) {
    if (!iso) return '—';
    try {
        return new Date(iso).toLocaleDateString(lang === 'en' ? 'en-GB' : 'ru-RU', {
            day: 'numeric', month: 'long', year: 'numeric',
        });
    } catch {
        return iso;
    }
}

export function periodLabel(lang, period) {
    const map = {
        ru: { month: 'мес', quarter: 'квартал', year: 'год' },
        en: { month: 'mo', quarter: 'quarter', year: 'year' },
    };
    return (map[lang] || map.ru)[period] || period;
}

/* ----------------------------- Keyboards ------------------------------ */

export function mainMenu(lang, loggedIn) {
    const kb = new InlineKeyboard();

    if (loggedIn) {
        kb.text(t(lang, 'btn_account'), 'nav:account').text(t(lang, 'btn_connections'), 'nav:connections').row()
            .text(t(lang, 'btn_devices'), 'nav:devices').text(t(lang, 'btn_referrals'), 'nav:referrals').row()
            .text(t(lang, 'btn_plans'), 'nav:plans').text(t(lang, 'btn_docs'), 'nav:docs').row()
            .text(t(lang, 'btn_support'), 'nav:support').text(t(lang, 'btn_lang'), 'act:lang').row()
            .text(t(lang, 'btn_logout'), 'act:logout');
    } else {
        kb.text(t(lang, 'btn_login'), 'act:login').row()
            .text(t(lang, 'btn_plans'), 'nav:plans').text(t(lang, 'btn_docs'), 'nav:docs').row()
            .text(t(lang, 'btn_support'), 'nav:support').text(t(lang, 'btn_lang'), 'act:lang');
    }

    return kb;
}

export function backMenu(lang) {
    return new InlineKeyboard().text(t(lang, 'btn_back'), 'nav:main');
}

export function cancelMenu(lang) {
    return new InlineKeyboard().text(t(lang, 'btn_cancel'), 'act:cancel');
}

export const DOCS_PLATFORMS = [
    { slug: 'windows', label: 'Windows' },
    { slug: 'macos', label: 'macOS' },
    { slug: 'linux', label: 'Linux' },
    { slug: 'android', label: 'Android' },
    { slug: 'ios', label: 'iPhone / iPad' },
    { slug: 'android-tv', label: 'Android TV' },
    { slug: 'smart-tv', label: 'Smart TV' },
    { slug: 'routers', label: 'Router' },
];

export function docsMenu(lang) {
    const kb = new InlineKeyboard();
    DOCS_PLATFORMS.forEach((platform, index) => {
        kb.url(platform.label, `${config.siteUrl}/${lang}/docs/${platform.slug}`);
        if (index % 2 === 1) kb.row();
    });
    kb.row().text(t(lang, 'btn_back'), 'nav:main');
    return kb;
}

export function plansMenu(lang) {
    return new InlineKeyboard()
        .url(t(lang, 'btn_open_site'), `${config.siteUrl}/${lang}/pricing`).row()
        .text(t(lang, 'btn_back'), 'nav:main');
}

export function dashboardMenu(lang) {
    return new InlineKeyboard()
        .url(t(lang, 'btn_to_dashboard'), `${config.siteUrl}/dashboard`).row()
        .text(t(lang, 'btn_back'), 'nav:main');
}
