<?php

return [
    'user_role' => [
        'user' => 'Пользователь',
        'admin' => 'Администратор',
    ],
    'subscription_status' => [
        'pending' => 'Ожидает оплаты',
        'trialing' => 'Пробный период',
        'active' => 'Активна',
        'expired' => 'Истекла',
        'canceled' => 'Отменена',
    ],
    'payment_status' => [
        'pending' => 'В обработке',
        'paid' => 'Оплачен',
        'failed' => 'Ошибка',
        'refunded' => 'Возврат',
    ],
    'payment_method' => [
        'card' => 'Банковская карта',
        'sbp' => 'СБП',
        'crypto' => 'Цифровые активы',
    ],
    'server_status' => [
        'online' => 'В сети',
        'maintenance' => 'Обслуживание',
        'offline' => 'Недоступен',
    ],
    'connection_status' => [
        'active' => 'Активно',
        'paused' => 'Приостановлено',
        'revoked' => 'Отозвано',
    ],
    'article_status' => [
        'draft' => 'Черновик',
        'published' => 'Опубликовано',
    ],
    'review_status' => [
        'pending' => 'На модерации',
        'approved' => 'Одобрен',
        'rejected' => 'Отклонён',
    ],
    'device_platform' => [
        'windows' => 'Windows',
        'macos' => 'macOS',
        'linux' => 'Linux',
        'android' => 'Android',
        'ios' => 'iPhone / iPad',
        'androidtv' => 'Android TV',
        'smarttv' => 'Smart TV',
        'router' => 'Роутер',
    ],
    'promo_type' => [
        'percent' => 'Процент',
        'fixed' => 'Фиксированная сумма',
    ],
    'notification_type' => [
        'system' => 'Системное',
        'billing' => 'Оплата',
        'security' => 'Безопасность',
        'promo' => 'Акция',
    ],
    'billing_period' => [
        'month' => 'месяц',
        'quarter' => 'квартал',
        'year' => 'год',
    ],
    'referral_status' => [
        'pending' => 'Ожидает',
        'confirmed' => 'Подтверждён',
        'rewarded' => 'Начислено',
    ],
    'payout_status' => [
        'pending' => 'Ожидает',
        'approved' => 'Одобрена',
        'paid' => 'Выплачена',
        'rejected' => 'Отклонена',
    ],
];
