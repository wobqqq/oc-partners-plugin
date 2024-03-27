<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Cache;

class BasicCache
{
    protected const TTL = 600;

    protected function generateCacheKey(...$args): string
    {
        $args[] = static::class;
        $args = array_map(function ($value) {
            if (is_object($value) || is_array($value)) {
                return serialize($value);
            }

            return (string)$value;
        }, $args);

        $key = implode('-', $args);
        $key = md5($key);

        return $key;
    }
}
