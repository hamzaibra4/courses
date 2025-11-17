<?php

if (!function_exists('isActiveRoute')) {
    /**
     * Check if the current route matches the given route(s).
     *
     * @param mixed $routes - A string or array of route names to check.
     * @param string $output - The output string if the route is active.
     * @return string - Returns the output string if the route is active, otherwise an empty string.
     */
    function isActiveRoute($routes, $output = "active") {
        if (is_array($routes)) {
            return in_array(Route::currentRouteName(), $routes) ? $output : '';
        }
        return Route::currentRouteName() == $routes ? $output : '';
    }
}
