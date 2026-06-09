const dict = {
    ru: {
        // Buttons
        btn_account: '👤 Мой аккаунт',
        btn_connections: '🔌 Подключения',
        btn_devices: '📱 Устройства',
        btn_plans: '💳 Тарифы',
        btn_referrals: '🎁 Рефералы',
        btn_docs: '📚 Документация',
        btn_support: '🆘 Поддержка',
        btn_login: '🔐 Войти',
        btn_register: '🆕 Создать аккаунт',
        btn_logout: '🚪 Выйти',
        btn_lang: '🌐 EN',
        btn_back: '‹ Назад',
        btn_open_site: '🌐 Открыть сайт',
        btn_renew: '🔄 Продлить',
        btn_cancel: 'Отмена',
        btn_to_dashboard: '🖥 Личный кабинет',

        // General
        welcome: '🛡 <b>Flux</b> — защищённое соединение и приватный доступ в интернет.\n\nЯ помогу управлять подпиской, подключениями и устройствами прямо в Telegram. Выберите раздел:',
        welcome_back: 'С возвращением, <b>:name</b>! Выберите раздел:',
        pick_section: 'Выберите раздел:',
        need_login: '🔐 Чтобы продолжить, войдите в аккаунт Flux.',
        error: '⚠️ Что-то пошло не так. Попробуйте позже.',
        canceled: 'Действие отменено.',
        loading: '⏳ Загружаю…',

        // Auth
        login_intro: '🔐 <b>Вход в Flux</b>\n\nВведите email, указанный при регистрации на сайте:',
        ask_password: 'Теперь введите пароль.\n\n<i>В целях безопасности я сразу удалю сообщение с паролем.</i>',
        bad_email: 'Это не похоже на email. Попробуйте ещё раз или нажмите «Отмена».',
        login_ok: '✅ Готово, <b>:name</b>! Вы вошли в аккаунт.',
        login_fail: '❌ Неверный email или пароль. Попробуйте ещё раз: /login',
        logout_ok: '👋 Вы вышли из аккаунта.',

        // Registration
        reg_intro: '🆕 <b>Регистрация в Flux</b>\n\nДавайте создадим аккаунт. Как вас зовут?',
        reg_ask_email: 'Отлично! Теперь введите ваш email:',
        reg_ask_password: 'Придумайте пароль (минимум 8 символов).\n\n<i>Сообщение с паролем я сразу удалю.</i>',
        reg_password_short: 'Пароль слишком короткий — нужно минимум 8 символов. Введите ещё раз:',
        reg_email_taken: '✋ Этот email уже зарегистрирован. Введите другой email или войдите: /login',
        reg_success: '🎉 Аккаунт создан, <b>:name</b>!\n\n✅ Активирован <b>бесплатный пробный период на 14 дней</b> — подключения уже готовы.\n\nДобро пожаловать в Flux!',
        reg_failed: '❌ Не удалось завершить регистрацию. Попробуйте позже: /register',
        reg_telegram_linked: 'У этого Telegram уже есть аккаунт Flux. Нажмите «🔐 Войти» или /login.',
        reg_already_exists: '✋ <b>Регистрация недоступна</b>\n\nНа этот Telegram уже зарегистрирован аккаунт <b>:name</b>. Один Telegram — один аккаунт сервиса.\n\nВы вошли в свой аккаунт — выберите раздел:',

        // Account
        account_title: '👤 <b>Аккаунт</b>',
        acc_email: '✉️ Email: <b>:email</b>',
        acc_plan: '💼 Тариф: <b>:plan</b>',
        acc_status: '📶 Статус: <b>:status</b>',
        acc_until: '📅 Действует до: <b>:date</b>',
        acc_days: '⏳ Осталось дней: <b>:days</b>',
        acc_balance: '💰 Баланс: <b>:balance ₽</b>',
        acc_no_sub: '📭 Активной подписки нет. Оформите тариф на сайте.',

        // Connections
        connections_title: '🔌 <b>Подключения</b>',
        conn_none: '📭 Активных подключений нет. Они создаются после оформления подписки.',
        conn_pick: 'Выберите подключение, чтобы увидеть данные:',
        conn_server: '🌍 Сервер: <code>:server</code>',
        conn_key: '🔑 Ключ: <code>:key</code>',
        conn_link: '🔗 Ссылка для подключения:\n<code>:link</code>',
        conn_sub: '📥 Подписка (subscription):\n<code>:sub</code>',
        conn_region: '📍 Регион: <b>:region</b>',
        conn_status: '📶 Статус: <b>:status</b>',
        conn_copy_hint: '<i>Нажмите на значение, чтобы скопировать.</i>',

        // Devices
        devices_title: '📱 <b>Устройства</b>',
        dev_none: '📭 Устройства не добавлены.',

        // Plans
        plans_title: '💳 <b>Тарифы Flux</b>',
        plan_devices: 'до :count устр.',
        plan_popular: '⭐️ Популярный',
        plans_hint: 'Оформление и оплата — на сайте.',

        // Referrals
        referrals_title: '🎁 <b>Реферальная программа</b>',
        ref_invited: '👥 Приглашено: <b>:count</b>',
        ref_balance: '💰 Баланс: <b>:balance ₽</b>',
        ref_code: '🏷 Код: <code>:code</code>',
        ref_link: '🔗 Ваша ссылка:\n:link',
        ref_hint: 'Делитесь ссылкой и получайте вознаграждение с оплат приглашённых пользователей.',

        // Docs
        docs_title: '📚 <b>Документация</b>\n\nВыберите платформу — откроется пошаговая инструкция на сайте:',

        // Support
        support_title: '🆘 <b>Поддержка</b>',
        support_text: 'Мы на связи круглосуточно и поможем с настройкой.',
        support_email: '✉️ Email: :email',
        support_tg: '💬 Telegram: :tg',

        // Statuses
        status_active: 'Активна',
        status_trialing: 'Пробный период',
        status_pending: 'Ожидает оплаты',
        status_expired: 'Истекла',
        status_canceled: 'Отменена',
        status_paused: 'Приостановлено',
        status_revoked: 'Отозвано',
    },

    en: {
        btn_account: '👤 My account',
        btn_connections: '🔌 Connections',
        btn_devices: '📱 Devices',
        btn_plans: '💳 Plans',
        btn_referrals: '🎁 Referrals',
        btn_docs: '📚 Docs',
        btn_support: '🆘 Support',
        btn_login: '🔐 Log in',
        btn_register: '🆕 Create account',
        btn_logout: '🚪 Log out',
        btn_lang: '🌐 RU',
        btn_back: '‹ Back',
        btn_open_site: '🌐 Open website',
        btn_renew: '🔄 Renew',
        btn_cancel: 'Cancel',
        btn_to_dashboard: '🖥 Dashboard',

        welcome: '🛡 <b>Flux</b> — secure connection and private internet access.\n\nManage your subscription, connections and devices right in Telegram. Pick a section:',
        welcome_back: 'Welcome back, <b>:name</b>! Pick a section:',
        pick_section: 'Pick a section:',
        need_login: '🔐 Please log in to your Flux account to continue.',
        error: '⚠️ Something went wrong. Please try again later.',
        canceled: 'Action canceled.',
        loading: '⏳ Loading…',

        login_intro: '🔐 <b>Log in to Flux</b>\n\nEnter the email you used to register on the website:',
        ask_password: 'Now enter your password.\n\n<i>For security I will delete the password message immediately.</i>',
        bad_email: 'That does not look like an email. Try again or press "Cancel".',
        login_ok: '✅ Done, <b>:name</b>! You are logged in.',
        login_fail: '❌ Invalid email or password. Try again: /login',
        logout_ok: '👋 You have logged out.',

        // Registration
        reg_intro: '🆕 <b>Sign up for Flux</b>\n\nLet\'s create your account. What is your name?',
        reg_ask_email: 'Great! Now enter your email:',
        reg_ask_password: 'Create a password (at least 8 characters).\n\n<i>I will delete the password message right away.</i>',
        reg_password_short: 'Password is too short — at least 8 characters are required. Try again:',
        reg_email_taken: '✋ This email is already registered. Use another email or log in: /login',
        reg_success: '🎉 Account created, <b>:name</b>!\n\n✅ Your <b>14-day free trial</b> is active — connections are ready.\n\nWelcome to Flux!',
        reg_failed: '❌ Registration could not be completed. Please try again later: /register',
        reg_telegram_linked: 'This Telegram already has a Flux account. Tap "🔐 Log in" or /login.',
        reg_already_exists: '✋ <b>Registration unavailable</b>\n\nThis Telegram already has an account <b>:name</b>. One Telegram — one service account.\n\nYou are now logged in — pick a section:',

        account_title: '👤 <b>Account</b>',
        acc_email: '✉️ Email: <b>:email</b>',
        acc_plan: '💼 Plan: <b>:plan</b>',
        acc_status: '📶 Status: <b>:status</b>',
        acc_until: '📅 Valid until: <b>:date</b>',
        acc_days: '⏳ Days left: <b>:days</b>',
        acc_balance: '💰 Balance: <b>:balance ₽</b>',
        acc_no_sub: '📭 No active subscription. Choose a plan on the website.',

        connections_title: '🔌 <b>Connections</b>',
        conn_none: '📭 No active connections. They are created after you subscribe.',
        conn_pick: 'Pick a connection to see its details:',
        conn_server: '🌍 Server: <code>:server</code>',
        conn_key: '🔑 Key: <code>:key</code>',
        conn_link: '🔗 Connection link:\n<code>:link</code>',
        conn_sub: '📥 Subscription:\n<code>:sub</code>',
        conn_region: '📍 Region: <b>:region</b>',
        conn_status: '📶 Status: <b>:status</b>',
        conn_copy_hint: '<i>Tap a value to copy it.</i>',

        devices_title: '📱 <b>Devices</b>',
        dev_none: '📭 No devices added.',

        plans_title: '💳 <b>Flux plans</b>',
        plan_devices: 'up to :count dev.',
        plan_popular: '⭐️ Popular',
        plans_hint: 'Checkout and payment are on the website.',

        referrals_title: '🎁 <b>Referral program</b>',
        ref_invited: '👥 Invited: <b>:count</b>',
        ref_balance: '💰 Balance: <b>:balance ₽</b>',
        ref_code: '🏷 Code: <code>:code</code>',
        ref_link: '🔗 Your link:\n:link',
        ref_hint: 'Share your link and earn rewards from invited users\' payments.',

        docs_title: '📚 <b>Documentation</b>\n\nPick a platform — a step-by-step guide opens on the website:',

        support_title: '🆘 <b>Support</b>',
        support_text: 'We are available around the clock and happy to help.',
        support_email: '✉️ Email: :email',
        support_tg: '💬 Telegram: :tg',

        status_active: 'Active',
        status_trialing: 'Trial',
        status_pending: 'Pending',
        status_expired: 'Expired',
        status_canceled: 'Canceled',
        status_paused: 'Paused',
        status_revoked: 'Revoked',
    },
};

export const LANGS = ['ru', 'en'];

export function t(lang, key, vars = {}) {
    const table = dict[lang] || dict.ru;
    const template = table[key] ?? dict.ru[key] ?? key;
    return template.replace(/:(\w+)/g, (_, name) => (vars[name] ?? `:${name}`));
}
