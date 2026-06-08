import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import focus from '@alpinejs/focus';
import persist from '@alpinejs/persist';

Alpine.plugin(collapse);
Alpine.plugin(focus);
Alpine.plugin(persist);

/* ---------------------------------------------------------------------------
 * Theme store — light / dark with persistence + system fallback.
 * The initial class is applied by an inline <head> script to avoid FOUC;
 * this store keeps it in sync and exposes a toggle for the theme switcher.
 * ------------------------------------------------------------------------- */
Alpine.store('theme', {
    current: localStorage.getItem('flux-theme') || 'system',

    init() {
        this.apply();
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (this.current === 'system') this.apply();
        });
    },

    get isDark() {
        if (this.current === 'system') {
            return window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
        return this.current === 'dark';
    },

    apply() {
        document.documentElement.classList.toggle('dark', this.isDark);
    },

    set(value) {
        this.current = value;
        localStorage.setItem('flux-theme', value);
        this.apply();
    },

    toggle() {
        this.set(this.isDark ? 'light' : 'dark');
    },
});

/* ---------------------------------------------------------------------------
 * Toast store — lightweight, dismissible notifications used app-wide.
 * ------------------------------------------------------------------------- */
Alpine.store('toasts', {
    items: [],
    push(message, type = 'success', timeout = 4200) {
        const id = Date.now() + Math.random();
        this.items.push({ id, message, type });
        if (timeout) setTimeout(() => this.dismiss(id), timeout);
    },
    dismiss(id) {
        this.items = this.items.filter((t) => t.id !== id);
    },
});

/* ---------------------------------------------------------------------------
 * Reusable Alpine data components
 * ------------------------------------------------------------------------- */
Alpine.data('copyField', (value) => ({
    copied: false,
    value,
    async copy() {
        try {
            await navigator.clipboard.writeText(this.value);
        } catch {
            const el = document.createElement('textarea');
            el.value = this.value;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            el.remove();
        }
        this.copied = true;
        setTimeout(() => (this.copied = false), 1800);
    },
}));

window.Alpine = Alpine;
Alpine.start();

/* ---------------------------------------------------------------------------
 * Scroll reveal — progressively reveals elements with the `.reveal` class.
 * Dependency-free; respects reduced-motion preferences.
 * ------------------------------------------------------------------------- */
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const revealItems = () => document.querySelectorAll('.reveal:not(.is-visible)');

if (reduceMotion || !('IntersectionObserver' in window)) {
    document.addEventListener('DOMContentLoaded', () =>
        revealItems().forEach((el) => el.classList.add('is-visible'))
    );
} else {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.08 }
    );

    const attach = () => revealItems().forEach((el) => observer.observe(el));
    document.addEventListener('DOMContentLoaded', attach);
    document.addEventListener('alpine:initialized', attach);
}
