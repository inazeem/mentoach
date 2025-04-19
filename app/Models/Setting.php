<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['group', 'key', 'value'];

    /**
     * Get all settings for a group
     */
    public static function getGroup(string $group): array
    {
        return Cache::remember("settings.{$group}", 3600, function () use ($group) {
            return static::where('group', $group)
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    /**
     * Get a specific setting
     */
    public static function get(string $group, string $key, $default = null)
    {
        return Cache::remember("settings.{$group}.{$key}", 3600, function () use ($group, $key, $default) {
            $setting = static::where('group', $group)
                ->where('key', $key)
                ->first();
            
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a specific setting
     */
    public static function set(string $group, string $key, $value): void
    {
        static::updateOrCreate(
            ['group' => $group, 'key' => $key],
            ['value' => $value]
        );

        // Clear the cache for this setting
        Cache::forget("settings.{$group}.{$key}");
        Cache::forget("settings.{$group}");
    }

    /**
     * Set multiple settings for a group
     */
    public static function setGroup(string $group, array $settings): void
    {
        foreach ($settings as $key => $value) {
            static::set($group, $key, $value);
        }
    }
} 