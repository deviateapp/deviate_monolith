<?php

namespace Deviate\Organisations\Models\Values;

use Illuminate\Support\Str;

class Slug
{
    public static function optional(array $data, string $key): ?string
    {
        if (array_key_exists($key, $data)) {
            return static::format($data[$key]);
        }

        return null;
    }

    public static function format(string $slug): string
    {
        return Str::slug($slug);
    }
}
