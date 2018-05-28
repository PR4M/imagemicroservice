<?php
/**
 * Created by PhpStorm.
 * User: Pramana
 * Date: 5/28/2018
 * Time: 12:16 PM
 */

/*
 * If base_path() is not exist, create.
 */
if (!function_exists('base_path')) {
    function base_path($path = '') {
        return __DIR__ . '/..//' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

/*
 * if uploads_path is not exist, create.
 */
if (!function_exists('uploads_path')) {
    function uploads_path($path = '') {
        return base_path('storage/uploads/' . $path);
    }
}