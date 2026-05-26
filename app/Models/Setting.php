<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'logo',
        'whatsapp_number',
        'facebook',
        'instagram',
        'youtube',
        'telegram',
        'email',
        'address',
    ];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('site_settings');
        });
    }

    public static function current(): self
    {
        return Cache::remember('site_settings', now()->addDay(), function () {
            return self::firstOrCreate(['id' => 1], ['site_name' => config('app.name', 'ftech')]);
        });
    }
}
