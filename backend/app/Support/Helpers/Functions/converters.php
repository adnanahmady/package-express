<?php

if (!function_exists('toArray')) {
    function toArray(string $json): array|false
    {
        return json_decode($json, true);
    }
}
