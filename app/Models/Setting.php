<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function setValue($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public static function getLogoUrl()
    {
        $logoPath = self::getValue('logo_path', 'logo/default-logo.png');
        return asset('storage/' . $logoPath);
    }

    public static function getQrisUrl()
    {
        $qrisPath = self::getValue('qris_image_path');
        return $qrisPath ? asset('storage/' . $qrisPath) : null;
    }
}