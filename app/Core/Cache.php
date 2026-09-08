<?php
declare(strict_types=1);

namespace Oftalvista\Core;

use Redis;
use Throwable;

final class Cache
{
    private static ?Redis $redis = null;
    private static bool $attempted = false;

    public static function redis(): ?Redis
    {
        if (self::$attempted) return self::$redis;
        self::$attempted = true;
        if (!class_exists(Redis::class)) return null;
        try {
            $redis = new Redis();
            $redis->connect(Config::get('REDIS_HOST', 'redis'), (int) Config::get('REDIS_PORT', '6379'), 1.5);
            $redis->setOption(Redis::OPT_PREFIX, 'oftalvista:');
            self::$redis = $redis;
        } catch (Throwable) {
            self::$redis = null;
        }
        return self::$redis;
    }

    public static function forgetBlog(): void
    {
        $redis = self::redis();
        if (!$redis) return;
        foreach ($redis->keys('blog:*') ?: [] as $key) $redis->del(str_replace('oftalvista:', '', $key));
    }
}
