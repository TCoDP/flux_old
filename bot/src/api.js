import axios from 'axios';
import { config } from './config.js';

const http = axios.create({
    baseURL: config.apiBaseUrl,
    timeout: 12000,
    headers: { Accept: 'application/json' },
});

const auth = (token) => ({ headers: { Authorization: `Bearer ${token}` } });

export async function register({ name, email, password, telegramId, referralCode, locale }) {
    const { data } = await http.post('/auth/register', {
        name,
        email,
        password,
        telegram_id: telegramId,
        referral_code: referralCode,
        locale,
    });
    return data; // { token, user: { name, email } }
}

/** Recognise a returning Telegram user via the trusted bot channel. Returns null if not registered. */
export async function telegramLogin(telegramId) {
    if (!config.botApiSecret) return null;
    try {
        const { data } = await http.post(
            '/auth/telegram',
            { telegram_id: String(telegramId) },
            { headers: { 'X-Bot-Secret': config.botApiSecret } },
        );
        return data; // { token, user }
    } catch (error) {
        if (error.response?.status === 404) return null; // no linked account yet
        throw error;
    }
}

export async function login(email, password, telegramId) {
    const { data } = await http.post('/auth/login', {
        email,
        password,
        telegram_id: telegramId,
        device_name: 'telegram-bot',
    });
    return data; // { token, user: { name, email } }
}

/** Extract a human-friendly message from an API error (validation or message). */
export function errorMessage(error) {
    const res = error?.response?.data;
    if (res?.errors) {
        const first = Object.values(res.errors)[0];
        if (Array.isArray(first) && first[0]) return first[0];
    }
    return res?.message || null;
}

export async function logout(token) {
    try {
        await http.post('/auth/logout', {}, auth(token));
    } catch {
        // ignore — token will be dropped locally anyway
    }
}

export async function getMe(token) {
    const { data } = await http.get('/me', auth(token));
    return data.data;
}

export async function getConnections(token) {
    const { data } = await http.get('/connections', auth(token));
    return data.data;
}

export async function getConnection(token, uuid) {
    const { data } = await http.get(`/connections/${uuid}`, auth(token));
    return data.data;
}

export async function getDevices(token) {
    const { data } = await http.get('/devices', auth(token));
    return data.data;
}

export async function getPlans() {
    const { data } = await http.get('/plans');
    return data.data;
}

export async function getMeta() {
    const { data } = await http.get('/meta');
    return data.data;
}

export function isAuthError(error) {
    return error?.response?.status === 401;
}
