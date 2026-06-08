# 🛡️ Flux — защищённое соединение и приватный доступ в интернет

Премиальный коммерческий SaaS-продукт для предоставления **защищённого сетевого соединения** и **приватного доступа в интернет**. Построен на Laravel 12 с акцентом на enterprise-архитектуру, переиспользуемые компоненты и современный дизайн уровня Stripe / Linear / Vercel.

---

## Технологический стек

| Слой | Технология |
|------|-----------|
| Backend | Laravel **12** (PHP 8.2+) |
| Шаблоны | Blade + компоненты (дизайн-система ~45 компонентов) |
| Стили | TailwindCSS **4** (CSS-first, дизайн-токены) |
| Интерактив | Alpine.js 3 (`collapse`, `focus`, `persist`) |
| Сборка | Vite 6 |
| База данных | MySQL 8 |
| API | Laravel **Sanctum** (персональные токены) |
| Очереди | Laravel Queue (`database`) |
| Планировщик | Laravel Scheduler |
| 2FA | `pragmarx/google2fa` + `bacon/bacon-qr-code` |

## Ключевые возможности

- **Публичный сайт:** главная (hero, преимущества, карта покрытия, тарифы, FAQ, отзывы, CTA), о сервисе, тарифы, FAQ, контакты, блог + статья, политика конфиденциальности, пользовательское соглашение.
- **Документация** по 8 платформам (Windows, macOS, Linux, Android, iPhone/iPad, Android TV, Smart TV, роутеры) с поиском, пошаговыми инструкциями, блоками копирования и FAQ.
- **Личный кабинет:** дашборд, подписки, устройства, управление подключениями, история платежей, продление, реферальная программа, промокоды, уведомления, профиль, безопасность (2FA), API-доступ.
- **Админ-панель:** дашборд, пользователи, подписки, тарифы, серверы, регионы, платежи, промокоды, статьи, отзывы, рефералы, уведомления (рассылки), логи действий, настройки проекта, SEO.
- **Мультиязычность** (RU/EN) с URL-префиксами `/ru`, `/en` и `hreflang`.
- **SEO:** OpenGraph, Schema.org (JSON-LD), canonical, sitemap.xml, ЧПУ.
- **Безопасность:** 2FA (TOTP), подтверждение email, защита от брутфорса (rate limiting), CSRF, политика паролей.
- **Платежи:** банковские карты, СБП, цифровые активы (сервисный слой `BillingService`).
- **Тёмная и светлая тема**, glassmorphism, градиенты, плавные анимации, полная адаптивность.

> ⚖️ Позиционирование и тексты соответствуют требованиям законодательства РФ. Сервис описан как средство защиты данных и приватного доступа в интернет.

## Архитектура

```
app/
├── Enums/            # Типобезопасные статусы (label/color, i18n)
├── Http/
│   ├── Controllers/  # Public · Auth · Dashboard · Admin · Api · Docs
│   ├── Middleware/    # SetLocale · EnsureUserIsAdmin · EnsureTwoFactorIsConfirmed
│   └── Requests/      # Form Request валидация
├── Models/           # 18 моделей с связями, кастами, скоупами
├── Services/         # Billing · Referral · ConnectionProvisioner · TwoFactor · Seo · Settings · ActivityLogger
└── Support/          # Money, helpers (settings(), format_price(), locale_url())

resources/views/
├── components/       # Дизайн-система (button, glass-card, pricing-card, navbar, …)
│   ├── layouts/      # base · public · auth · dashboard · admin · docs
│   └── admin/        # row-actions, toolbar
├── public/ · auth/ · dashboard/ · docs/ · admin/
lang/ru · lang/en     # Полная локализация
```

## Установка

```bash
# 1. Зависимости
composer install
npm install

# 2. Окружение
cp .env.example .env
php artisan key:generate
# Настройте подключение к MySQL в .env (DB_DATABASE=flux …)

# 3. База данных
php artisan migrate --seed

# 4. Сборка фронтенда
npm run build      # или `npm run dev` для разработки

# 5. Запуск
php artisan serve
```

### Очереди и планировщик

```bash
php artisan queue:work          # обработка очередей (database)
php artisan schedule:work       # планировщик (продление, напоминания)
```

Зарегистрированные задачи планировщика:
- `flux:expire-subscriptions` — ежедневно отмечает истёкшие подписки;
- `flux:renewal-reminders` — уведомления о скором окончании подписки.

## Демо-доступы (после `--seed`)

| Роль | Email | Пароль |
|------|-------|--------|
| Администратор | `admin@flux.local` | `password` |
| Пользователь | `demo@flux.local` | `password` |

## API (Sanctum)

Токены создаются в личном кабинете (раздел «API-доступ»). Запросы — с заголовком `Authorization: Bearer <token>`:

- `GET /api/v1/me` — профиль и активная подписка
- `GET /api/v1/subscriptions` — список подписок
- `GET /api/v1/connections` — профили подключений
- `GET /api/v1/devices` — устройства
