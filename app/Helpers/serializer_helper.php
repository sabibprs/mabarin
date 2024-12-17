<?php

/**
 * Serialize Array to Object
 *
 * @param mixed $data
 * @return void
 */
if (!function_exists('to_object')) {
    function to_object(mixed $data): mixed
    {
        if (gettype($data) !== "array") return $data;
        return json_decode(json_encode($data), false);
    }
}

/**
 * Serialize Object to Array
 *
 * @param mixed $data
 * @return mixed
 */
if (!function_exists('to_array')) {
    function to_array(mixed $data): mixed
    {
        if (gettype($data) !== "object") return $data;
        return json_decode(json_encode($data), true);
    }
}
