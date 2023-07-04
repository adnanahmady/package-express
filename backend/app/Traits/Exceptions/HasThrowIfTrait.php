<?php

namespace App\Traits\Exceptions;

use App\ExceptionMessages\ExceptionMessageInterface;

trait HasThrowIfTrait
{
    public static function throwIf(
        bool $condition,
        ExceptionMessageInterface $message
    ): void {
        if ($condition) {
            self::throwAs($message);
        }
    }

    protected static function throwAs(
        ExceptionMessageInterface $message
    ): void {
        throw new static(500, $message);
    }
}
