<?php

return [
    'user_role' => ['user' => 'User', 'admin' => 'Administrator'],
    'subscription_status' => [
        'pending' => 'Pending', 'trialing' => 'Trial', 'active' => 'Active', 'expired' => 'Expired', 'canceled' => 'Canceled',
    ],
    'payment_status' => ['pending' => 'Processing', 'paid' => 'Paid', 'failed' => 'Failed', 'refunded' => 'Refunded'],
    'payment_method' => ['card' => 'Bank card', 'sbp' => 'SBP', 'crypto' => 'Digital assets'],
    'server_status' => ['online' => 'Online', 'maintenance' => 'Maintenance', 'offline' => 'Offline'],
    'connection_status' => ['active' => 'Active', 'paused' => 'Paused', 'revoked' => 'Revoked'],
    'article_status' => ['draft' => 'Draft', 'published' => 'Published'],
    'review_status' => ['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'],
    'device_platform' => [
        'windows' => 'Windows', 'macos' => 'macOS', 'linux' => 'Linux', 'android' => 'Android',
        'ios' => 'iPhone / iPad', 'androidtv' => 'Android TV', 'smarttv' => 'Smart TV', 'router' => 'Router',
    ],
    'promo_type' => ['percent' => 'Percentage', 'fixed' => 'Fixed amount'],
    'notification_type' => ['system' => 'System', 'billing' => 'Billing', 'security' => 'Security', 'promo' => 'Promo'],
    'billing_period' => ['month' => 'month', 'quarter' => 'quarter', 'year' => 'year'],
    'referral_status' => ['pending' => 'Pending', 'confirmed' => 'Confirmed', 'rewarded' => 'Rewarded'],
    'payout_status' => ['pending' => 'Pending', 'approved' => 'Approved', 'paid' => 'Paid', 'rejected' => 'Rejected'],
];
