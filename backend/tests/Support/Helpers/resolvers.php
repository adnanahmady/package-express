<?php

if (!function_exists('jsonReader')) {
    function jsonReader($path): \Tests\Support\ReaderInterface
    {
        return new \Tests\Support\JsonReader($path);
    }
}
