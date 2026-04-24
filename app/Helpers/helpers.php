<?php

if (!function_exists('mob_asset')) {
    function mob_asset($name)
    {
        $env = app()->environment();

        if ($env == 'production' || $env == 'development' || $env == 'test') {
            $asset = asset($name);

            if (strpos($asset, 'https://') !== false) {
                return $asset;
            }

            return str_replace('http://', 'https://', $asset);
        } elseif ($env == 'local') {
            return asset($name);
        }

        return asset($name);
    }
}

// if (!function_exists('sec_asset')) {
//     function sec_asset($name)
//     {
//         return mob_asset($name);
//     }
// }

if (!function_exists('sec_asset')) {
    function sec_asset($path)
    {
        if (app()->environment('local')) {
            return asset($path);
        }

        return secure_asset($path);
    }
}

if (!function_exists('icon_classes')) {
    function icon_classes(): array
    {
        static $icons = null;

        if ($icons !== null) {
            return $icons;
        }

        $iconsPath = storage_path('app/icons.txt');
        $icons = [];

        if (is_readable($iconsPath)) {
            $lines = file($iconsPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
            $icons = array_map(static function ($line) {
                return trim($line, " \t\n\r\0\x0B\",");
            }, $lines);
        }

        if (empty($icons)) {
            $icons = font_awesome_solid_icon_classes();
        }

        if (empty($icons)) {
            $icons = [
                'fa-solid fa-bullseye',
                'fa-solid fa-layer-group',
                'fa-solid fa-briefcase',
                'fa-solid fa-chart-line',
                'fa-solid fa-location-dot',
                'fa-solid fa-star',
                'fa-solid fa-handshake',
                'fa-solid fa-globe',
                'fa-solid fa-lightbulb',
                'fa-solid fa-users',
            ];
        }

        $icons = array_filter($icons);
        $icons = array_unique($icons);

        return $icons = array_values($icons);
    }
}

if (!function_exists('font_awesome_solid_icon_classes')) {
    function font_awesome_solid_icon_classes(): array
    {
        $iconsDirectory = public_path('lib/font-awesome-6.5.0/svgs/solid');
        $iconFiles = glob($iconsDirectory . '/*.svg') ?: [];

        $icons = array_map(static function ($iconFile) {
            return 'fa-solid fa-' . pathinfo($iconFile, PATHINFO_FILENAME);
        }, $iconFiles);

        sort($icons);

        return $icons;
    }
}

if (!function_exists('random_icon_classes')) {
    function random_icon_classes(int $limit = 45, ?string $currentIcon = null): array
    {
        $icons = icon_classes();
        shuffle($icons);
        $icons = array_slice($icons, 0, $limit);

        $currentIcon = trim((string) $currentIcon);
        if ($currentIcon !== '' && !in_array($currentIcon, $icons, true)) {
            array_unshift($icons, $currentIcon);
        }

        return $icons;
    }
}
