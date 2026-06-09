<?php

return [
    'saved' => 'Changes saved.',
    'deleted' => 'Record deleted.',
    'panel' => 'Admin panel',
    'new' => 'Create',
    'edit' => 'Edit',
    'confirm_delete' => 'Delete this record?',
    'search_placeholder' => 'Search…',

    'nav' => [
        'overview' => 'Overview', 'dashboard' => 'Dashboard', 'logs' => 'Activity logs',
        'catalog' => 'Catalog', 'plans' => 'Plans', 'servers' => 'Servers', 'regions' => 'Regions', 'promocodes' => 'Promo codes',
        'customers' => 'Customers', 'users' => 'Users', 'subscriptions' => 'Subscriptions', 'payments' => 'Payments', 'referrals' => 'Referrals',
        'content' => 'Content', 'articles' => 'Articles', 'reviews' => 'Reviews', 'notifications' => 'Notifications',
        'system' => 'System', 'settings' => 'Project settings', 'seo' => 'SEO settings',
    ],

    'bnav' => [
        'dashboard' => 'Dash',
        'users' => 'Users',
        'payments' => 'Pay',
        'more' => 'Menu',
    ],
    'dashboard' => [
        'title' => 'Dashboard', 'subtitle' => 'Key project metrics',
        'users' => 'Users', 'active_subs' => 'Active subscriptions', 'revenue' => 'Revenue', 'pending' => 'Pending payments',
        'servers' => 'Servers online', 'recent_users' => 'New users', 'recent_payments' => 'Recent payments', 'revenue_14d' => 'Revenue (14 days)',
    ],
    'users' => [
        'title' => 'Users', 'name' => 'Name', 'email' => 'Email', 'role' => 'Role', 'subscriptions' => 'Subs',
        'registered' => 'Registered', 'password' => 'Password', 'password_hint' => 'Leave empty to keep current', 'banned' => 'Banned',
    ],
    'plans' => [
        'title' => 'Plans', 'name' => 'Name', 'price' => 'Price', 'period' => 'Period', 'devices' => 'Devices',
        'popular' => 'Popular', 'active' => 'Active', 'features_hint' => 'One feature per line',
    ],
    'servers' => ['title' => 'Servers', 'name' => 'Name', 'region' => 'Region', 'hostname' => 'Hostname', 'load' => 'Load', 'capacity' => 'Capacity'],
    'regions' => ['title' => 'Regions', 'name' => 'Name', 'city' => 'City', 'flag' => 'Flag (emoji)', 'load' => 'Load, %', 'servers' => 'Servers'],
    'promocodes' => ['title' => 'Promo codes', 'code' => 'Code', 'type' => 'Type', 'value' => 'Value', 'uses' => 'Uses', 'expires' => 'Expires'],
    'subscriptions' => ['title' => 'Subscriptions', 'user' => 'User', 'plan' => 'Plan', 'until' => 'Until'],
    'payments' => ['title' => 'Payments', 'number' => 'Number', 'user' => 'User', 'amount' => 'Amount', 'method' => 'Method', 'total_paid' => 'Total received', 'change_status' => 'Change status'],
    'articles' => [
        'title' => 'Articles', 'name' => 'Title', 'category' => 'Category', 'status' => 'Status', 'published_at' => 'Published',
        'views' => 'Views', 'cover' => 'Cover (URL)', 'excerpt' => 'Excerpt', 'body' => 'Body',
    ],
    'reviews' => ['title' => 'Reviews', 'author' => 'Author', 'rating' => 'Rating', 'featured' => 'Featured', 'text' => 'Review text'],
    'referrals' => [
        'title' => 'Referral system', 'referrer' => 'Referrer', 'referred' => 'Referred', 'reward' => 'Reward',
        'payouts' => 'Payout requests', 'pending_total' => 'To be paid', 'approve' => 'Approve payout',
    ],
    'notifications' => [
        'title' => 'Notifications', 'create' => 'New broadcast', 'subject' => 'Title', 'body' => 'Body', 'type' => 'Type',
        'audience' => 'Audience', 'audience_all' => 'All users', 'audience_subscribers' => 'Active subscribers only',
        'action_url' => 'Link (optional)', 'send' => 'Send', 'sent' => 'Notification sent to :count recipients.',
        'recent' => 'Recent notifications', 'total' => 'Total sent',
    ],
    'logs' => ['title' => 'Activity logs', 'action' => 'Action', 'user' => 'User', 'ip' => 'IP address', 'when' => 'When'],
    'settings' => [
        'title' => 'Project settings', 'subtitle' => 'General site settings and contact details',
        'labels' => [
            'site_name' => 'Site name', 'site_tagline' => 'Tagline', 'support_email' => 'Support email', 'support_telegram' => 'Telegram',
            'support_phone' => 'Phone', 'company_legal' => 'Legal name', 'company_inn' => 'Tax ID',
            'servers_count' => 'Servers (for stats)', 'regions_count' => 'Regions (for stats)', 'users_count' => 'Users (for stats)', 'uptime' => 'Uptime, %',
        ],
    ],
    'seo' => [
        'title' => 'SEO settings', 'subtitle' => 'Meta tags per page and locale', 'page' => 'Page',
        'meta_title' => 'Title', 'meta_description' => 'Description', 'keywords' => 'Keywords', 'og_image' => 'OG image (URL)',
    ],
];
