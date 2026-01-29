<?php

namespace App\Helpers;

class EnvHelper
{
    public static function set(string $key, ?string $value): bool
    {
        $path = base_path('.env');

        if (!file_exists($path)) {
            return false;
        }

        $content = file_get_contents($path);
        $escapedValue = addslashes($value ?? '');

        // Use quotes if the value contains spaces
        if (str_contains($escapedValue, ' ')) {
            $escapedValue = '"' . $escapedValue . '"';
        }

        if (str_contains($content, "{$key}=")) {
            // Replace existing key
            $content = preg_replace(
                "/^{$key}=.*/m",
                "{$key}={$escapedValue}",
                $content
            );
        } else {
            // Append new key
            $content .= "\n{$key}={$escapedValue}";
        }

        return file_put_contents($path, $content) !== false;
    }
}
