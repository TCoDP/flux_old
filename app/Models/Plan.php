<?php

namespace App\Models;

use App\Enums\BillingPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    /** @use HasFactory<\Database\Factories\PlanFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'tagline', 'description', 'price', 'old_price', 'currency',
        'billing_period', 'billing_months', 'device_limit', 'trial_days',
        'features', 'is_popular', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'old_price' => 'decimal:2',
            'billing_period' => BillingPeriod::class,
            'features' => 'array',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function monthlyPrice(): float
    {
        return $this->billing_months > 0
            ? round((float) $this->price / $this->billing_months, 2)
            : (float) $this->price;
    }

    public function hasDiscount(): bool
    {
        return $this->old_price !== null && (float) $this->old_price > (float) $this->price;
    }

    public function discountPercent(): int
    {
        if (! $this->hasDiscount()) {
            return 0;
        }

        return (int) round((1 - (float) $this->price / (float) $this->old_price) * 100);
    }
}
