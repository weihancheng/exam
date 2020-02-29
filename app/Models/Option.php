<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Option extends Model
{
    protected $fillable = [
        'key',
        'value',
        'name'
    ];

    // 获取数据
    public static function get($key)
    {
        if (Cache::tags('options')->has($key)) {
            return Cache::tags('options')->get($key);
        } else {
            $value = self::query()->where('key', $key)->get('value')->toArray()[0]['value'];
            Cache::tags('options')->put($key, $value);
            return $value;
        }
    }
}
