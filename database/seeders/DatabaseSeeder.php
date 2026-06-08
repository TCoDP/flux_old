<?php

namespace Database\Seeders;

use App\Enums\ArticleStatus;
use App\Enums\ConnectionStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\ReviewStatus;
use App\Enums\ServerStatus;
use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Connection;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\PromoCode;
use App\Models\Region;
use App\Models\Review;
use App\Models\Server;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->plans();
        $this->regionsAndServers();
        $this->reviews();
        $this->articles();
        $this->promoCodes();
        $this->users();
    }

    private function plans(): void
    {
        $plans = [
            [
                'name' => 'Старт', 'slug' => 'start', 'tagline' => 'Для одного устройства',
                'price' => 199, 'old_price' => null, 'billing_period' => 'month', 'billing_months' => 1,
                'device_limit' => 1, 'sort_order' => 1,
                'features' => ['1 защищённое подключение', 'Базовая скорость', 'Поддержка по email'],
            ],
            [
                'name' => 'Стандарт', 'slug' => 'standard', 'tagline' => 'Оптимальный выбор',
                'price' => 399, 'old_price' => 499, 'billing_period' => 'month', 'billing_months' => 1,
                'device_limit' => 5, 'is_popular' => true, 'sort_order' => 2,
                'features' => ['Максимальная скорость', 'Все регионы', 'Приоритетная поддержка 24/7', 'Защита в публичных Wi-Fi'],
            ],
            [
                'name' => 'Премиум', 'slug' => 'premium', 'tagline' => 'Для всей семьи',
                'price' => 899, 'old_price' => 1290, 'billing_period' => 'quarter', 'billing_months' => 3,
                'device_limit' => 10, 'sort_order' => 3,
                'features' => ['10 устройств', 'Максимальная скорость', 'Выделенные серверы', 'Поддержка 24/7', 'Настройка на роутере'],
            ],
            [
                'name' => 'Год', 'slug' => 'yearly', 'tagline' => 'Выгода 40%',
                'price' => 3990, 'old_price' => 6588, 'billing_period' => 'year', 'billing_months' => 12,
                'device_limit' => 10, 'sort_order' => 4,
                'features' => ['Всё из Премиум', 'Экономия 40%', 'Бонус: +2 месяца', 'Персональный менеджер'],
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['slug' => $plan['slug']], $plan + ['is_active' => true, 'currency' => 'RUB']);
        }
    }

    private function regionsAndServers(): void
    {
        $regions = [
            ['name' => 'Москва', 'city' => 'Москва', 'country_code' => 'RU', 'flag' => '🇷🇺', 'load_percent' => 28],
            ['name' => 'Санкт-Петербург', 'city' => 'СПб', 'country_code' => 'RU', 'flag' => '🇷🇺', 'load_percent' => 34],
            ['name' => 'Нидерланды', 'city' => 'Амстердам', 'country_code' => 'NL', 'flag' => '🇳🇱', 'load_percent' => 41],
            ['name' => 'Германия', 'city' => 'Франкфурт', 'country_code' => 'DE', 'flag' => '🇩🇪', 'load_percent' => 37],
            ['name' => 'Финляндия', 'city' => 'Хельсинки', 'country_code' => 'FI', 'flag' => '🇫🇮', 'load_percent' => 22],
            ['name' => 'Турция', 'city' => 'Стамбул', 'country_code' => 'TR', 'flag' => '🇹🇷', 'load_percent' => 52],
            ['name' => 'США', 'city' => 'Нью-Йорк', 'country_code' => 'US', 'flag' => '🇺🇸', 'load_percent' => 46],
            ['name' => 'Япония', 'city' => 'Токио', 'country_code' => 'JP', 'flag' => '🇯🇵', 'load_percent' => 33],
            ['name' => 'Сингапур', 'city' => 'Сингапур', 'country_code' => 'SG', 'flag' => '🇸🇬', 'load_percent' => 39],
            ['name' => 'Казахстан', 'city' => 'Алматы', 'country_code' => 'KZ', 'flag' => '🇰🇿', 'load_percent' => 18],
            ['name' => 'Армения', 'city' => 'Ереван', 'country_code' => 'AM', 'flag' => '🇦🇲', 'load_percent' => 25],
            ['name' => 'ОАЭ', 'city' => 'Дубай', 'country_code' => 'AE', 'flag' => '🇦🇪', 'load_percent' => 44],
        ];

        foreach ($regions as $i => $data) {
            $region = Region::updateOrCreate(
                ['slug' => Str::slug($data['name'].'-'.$data['country_code'])],
                $data + ['is_active' => true, 'sort_order' => $i],
            );

            for ($s = 1; $s <= 2; $s++) {
                Server::updateOrCreate(
                    ['hostname' => strtolower($data['country_code']).$region->id.'-'.$s.'.flux.net'],
                    [
                        'region_id' => $region->id,
                        'name' => $data['name'].' #'.$s,
                        'status' => ServerStatus::Online,
                        'capacity' => 1000,
                        'current_load' => (int) ($data['load_percent'] * 10),
                        'is_active' => true,
                    ],
                );
            }
        }
    }

    private function reviews(): void
    {
        $reviews = [
            ['author_name' => 'Алексей М.', 'author_role' => 'Разработчик', 'rating' => 5, 'body' => 'Пользуюсь несколько месяцев — соединение стабильное, скорость отличная. Настроил за пару минут на всех устройствах.'],
            ['author_name' => 'Мария К.', 'author_role' => 'Дизайнер', 'rating' => 5, 'body' => 'Наконец-то нашла сервис, который не тормозит видео. Поддержка ответила за 5 минут. Рекомендую!'],
            ['author_name' => 'Дмитрий В.', 'author_role' => 'Предприниматель', 'rating' => 5, 'body' => 'Защищаю всю команду через корпоративный тариф. Удобный личный кабинет и прозрачные тарифы.'],
            ['author_name' => 'Ольга С.', 'author_role' => 'Маркетолог', 'rating' => 4, 'body' => 'Стабильно работает в поездках, спокойно подключаюсь в кафе и аэропортах. Данные под защитой.'],
            ['author_name' => 'Иван Т.', 'author_role' => 'Студент', 'rating' => 5, 'body' => 'Доступная цена и реально высокая скорость. Настройка по инструкции заняла минуту.'],
            ['author_name' => 'Екатерина Л.', 'author_role' => 'Фрилансер', 'rating' => 5, 'body' => 'Работаю с клиентами по всему миру — соединение ни разу не подвело. Очень довольна сервисом.'],
        ];

        foreach ($reviews as $review) {
            Review::updateOrCreate(
                ['author_name' => $review['author_name']],
                $review + ['locale' => 'ru', 'status' => ReviewStatus::Approved, 'is_featured' => true],
            );
        }
    }

    private function articles(): void
    {
        $security = ArticleCategory::updateOrCreate(['slug' => 'security'], ['name' => 'Безопасность', 'color' => 'brand']);
        $tips = ArticleCategory::updateOrCreate(['slug' => 'tips'], ['name' => 'Советы', 'color' => 'info']);

        $articles = [
            ['title' => 'Как защитить свои данные в публичном Wi-Fi', 'category_id' => $security->id, 'excerpt' => 'Простые правила безопасной работы в открытых сетях кафе, аэропортов и отелей.'],
            ['title' => '5 признаков надёжного сервиса защищённого соединения', 'category_id' => $tips->id, 'excerpt' => 'На что обратить внимание при выборе сервиса для приватного доступа в интернет.'],
            ['title' => 'Зачем шифровать интернет-трафик', 'category_id' => $security->id, 'excerpt' => 'Разбираемся, как шифрование защищает вашу цифровую конфиденциальность.'],
        ];

        foreach ($articles as $i => $article) {
            Article::updateOrCreate(
                ['slug' => Str::slug($article['title'])],
                $article + [
                    'locale' => 'ru',
                    'status' => ArticleStatus::Published,
                    'published_at' => now()->subDays($i * 3 + 1),
                    'reading_minutes' => 4 + $i,
                    'views' => rand(120, 980),
                    'body' => '<p>Это демонстрационная статья блога Flux о безопасной работе в сети и защите цифровой конфиденциальности.</p><h2>Почему это важно</h2><p>Защищённое соединение помогает сохранить ваши данные в безопасности при работе в публичных и домашних сетях.</p><ul><li>Шифрование трафика</li><li>Защита персональных данных</li><li>Стабильный доступ к онлайн-сервисам</li></ul><p>Подключите Flux и работайте в интернете спокойно.</p>',
                ],
            );
        }
    }

    private function promoCodes(): void
    {
        PromoCode::updateOrCreate(['code' => 'WELCOME'], ['type' => 'percent', 'value' => 20, 'per_user_limit' => 1, 'is_active' => true]);
        PromoCode::updateOrCreate(['code' => 'BONUS300'], ['type' => 'fixed', 'value' => 300, 'per_user_limit' => 1, 'is_active' => true]);
    }

    private function users(): void
    {
        User::updateOrCreate(['email' => 'admin@flux.local'], [
            'name' => 'Администратор',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin,
            'email_verified_at' => now(),
        ]);

        $demo = User::updateOrCreate(['email' => 'demo@flux.local'], [
            'name' => 'Иван Демидов',
            'password' => Hash::make('password'),
            'role' => UserRole::User,
            'email_verified_at' => now(),
            'balance' => 640,
        ]);

        $plan = Plan::where('slug', 'standard')->first();

        $subscription = Subscription::updateOrCreate(
            ['user_id' => $demo->id, 'plan_id' => $plan->id],
            [
                'status' => SubscriptionStatus::Active,
                'starts_at' => now()->subDays(12),
                'ends_at' => now()->addDays(18),
                'auto_renew' => true,
            ],
        );

        $server = Server::where('status', ServerStatus::Online)->inRandomOrder()->first();

        if ($demo->connections()->count() === 0) {
            foreach (['MacBook Pro', 'iPhone 15'] as $name) {
                Connection::create([
                    'user_id' => $demo->id,
                    'subscription_id' => $subscription->id,
                    'server_id' => $server?->id,
                    'name' => $name,
                    'status' => ConnectionStatus::Active,
                    'last_handshake_at' => now()->subMinutes(rand(2, 90)),
                    'bytes_up' => rand(10, 90) * 1_000_000,
                    'bytes_down' => rand(100, 900) * 1_000_000,
                ]);
            }
        }

        $demo->devices()->firstOrCreate(['name' => 'MacBook Pro'], ['platform' => 'macos', 'last_seen_at' => now(), 'is_active' => true]);
        $demo->devices()->firstOrCreate(['name' => 'iPhone 15'], ['platform' => 'ios', 'last_seen_at' => now()->subHours(2), 'is_active' => true]);

        if ($demo->payments()->count() === 0) {
            foreach ([0, 1, 2] as $m) {
                Payment::create([
                    'user_id' => $demo->id,
                    'subscription_id' => $subscription->id,
                    'plan_id' => $plan->id,
                    'amount' => $plan->price,
                    'currency' => 'RUB',
                    'method' => PaymentMethod::Card,
                    'status' => PaymentStatus::Paid,
                    'paid_at' => now()->subMonths($m),
                    'created_at' => now()->subMonths($m),
                ]);
            }
        }

        foreach ([
            ['type' => 'billing', 'title' => 'Оплата получена', 'body' => 'Подписка «Стандарт» успешно продлена.', 'icon' => 'credit-card'],
            ['type' => 'security', 'title' => 'Новый вход в аккаунт', 'body' => 'Выполнен вход с нового устройства.', 'icon' => 'shield'],
            ['type' => 'promo', 'title' => 'Дарим скидку 20%', 'body' => 'Используйте промокод WELCOME при следующей оплате.', 'icon' => 'gift'],
        ] as $n) {
            Notification::firstOrCreate(['user_id' => $demo->id, 'title' => $n['title']], $n);
        }
    }
}
