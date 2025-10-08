<?php

if (! function_exists('admin_login')) {
    function admin_login() {
        return config('admin.login');
    }
}

if (! function_exists('admin_route')) {
    function admin_route() {
        return config('admin.route');
    }
}

if (! function_exists('admin_route_name')) {
    function admin_route_name() {
        return config('admin.name');
    }
}

if (! function_exists('active_state')) {
    function active_state($url) {
        return request()->is(admin_route().$url);
    }
}