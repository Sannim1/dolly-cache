<?php

namespace Skurian\Dolly;

use Illuminate\Support\Facades\Cache;

class RussianCaching
{
    protected static $keys = [];

    public static function setUp($model)
    {
        static::$keys[] = $key = $model->getCacheKey();

        ob_start();

        return Cache::tags('views')->has($key);
    }

    public static function tearDown()
    {
        $key = array_pop(static::$keys);

        $html = ob_get_clean();

        return Cache::tags('views')->rememberForever($key, function () use ($html) {
            return $html;
        });
    }
}
