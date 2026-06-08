import 'dotenv/config';

function required(name) {
    const value = process.env[name];
    if (!value) {
        console.error(`[config] Missing required environment variable: ${name}`);
        console.error('Copy .env.example to .env and fill in the values.');
        process.exit(1);
    }
    return value;
}

const stripSlash = (url) => url.replace(/\/+$/, '');

export const config = {
    botToken: required('BOT_TOKEN'),
    apiBaseUrl: stripSlash(process.env.API_BASE_URL || 'http://127.0.0.1:8123/api/v1'),
    siteUrl: stripSlash(process.env.SITE_URL || 'http://127.0.0.1:8123'),
    defaultLang: process.env.DEFAULT_LANG === 'en' ? 'en' : 'ru',
    sessionFile: process.env.SESSION_FILE || './data/sessions.json',
};
