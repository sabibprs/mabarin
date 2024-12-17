<?php


if (!function_exists('is_active_route')) {
    function is_active_route(string $routePattern, bool $mathOnly = false, array $exclude = []): bool
    {
        $path = current_url(true)->getPath();

        if (isset($exclude['route']) && isset($exclude['matchOnly'])) {
            foreach ($exclude['route'] as $route) {
                if ($exclude['matchOnly']) return $path == $route ? true : false;
                if (strpos($path, $route) === 0) return false;
            }
        }

        if ($mathOnly) return $path == $routePattern ? true : false;
        return strpos($path, $routePattern) === 0 ? true : false;
    }
}

if (!function_exists('is_active_class')) {
    function is_active_class(string $routePattern, bool $mathOnly = false, array $exclude = []): string
    {
        $isActive = is_active_route($routePattern, $mathOnly, $exclude);
        return $isActive ? "active" : "";
    }
}
