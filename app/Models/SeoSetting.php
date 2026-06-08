<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    /** @use HasFactory<\Database\Factories\SeoSettingFactory> */
    use HasFactory;

    protected $fillable = [
        'page', 'locale', 'title', 'description', 'keywords', 'og_image', 'schema',
    ];

    protected function casts(): array
    {
        return [
            'schema' => 'array',
        ];
    }
}
