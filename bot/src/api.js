import axios from 'axios';
import { config } from './config.js';

const http = axios.create({
    baseURL: config.apiBaseUrl,
    timeout: 12000,
    headers: { Accept: 'application/json' },
});

const auth = (token) => ({ headers: { Authorization: `Bearer ${token}` } });

export async function login(email, password) {
    const { data } = await http.post('/auth/login', {
        email,
        password,
        device_name: 'telegram-bot',
    });
    return data; // { token, user: { name, email } }
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
