<?php

namespace App\Exceptions;

use App\ExceptionMessages\ExceptionMessageInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidGeoJsonException extends HttpException
{
    public static function throwIf(
        bool $condition,
        ExceptionMessageInterface $message
    ): void {
        if ($condition) {
            throw new static(500, $message);
        }
    }
}
