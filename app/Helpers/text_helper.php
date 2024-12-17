<?php

use CodeIgniter\I18n\Time;

if (!function_exists('initial_name')) {
    function initial_name(string $name, string | null $separator = null)
    {
        $initial = "";
        $names = explode(' ', $name);
        $separator = !empty($separator) ? $separator : "";

        foreach ($names as $name) {
            $initial .= mb_substr($name, 0, 1, "UTF-8") . $separator;
        }

        return rtrim($initial, $separator);
    }
}

if (!function_exists('first_name')) {
    function first_name(string $name, string | null $separator = null): string
    {
        $firstName = explode($separator ?? ' ', $name)[0];
        return ucfirst($firstName);
    }
}

if (!function_exists('humanizeTimestamp')) {
    function humanizeTimestamp(string|int $timestamp): string
    {
        if (is_string($timestamp)) $timestamp = strtotime($timestamp);

        $time = Time::createFromTimestamp($timestamp, "Asia/Jakarta", "id_ID");
        return $time->humanize();
    }
}

if (!function_exists('readableTimestamp')) {
    function readableTimestamp(string|int $timestamp): string
    {
        if (is_string($timestamp)) $timestamp = strtotime($timestamp);
        $time = Time::createFromTimestamp($timestamp, "Asia/Jakarta", "id_ID");

        return $time->toLocalizedString('HH:mm. EEEE, dd MMMM yyyy', 'short');
    }
}
