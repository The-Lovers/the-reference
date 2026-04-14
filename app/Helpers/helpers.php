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
