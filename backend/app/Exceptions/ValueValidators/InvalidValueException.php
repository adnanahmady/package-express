<?php

namespace App\Exceptions\ValueValidators;

use App\Traits\Exceptions\HasThrowIfTrait;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidValueException extends HttpException
{
    use HasThrowIfTrait;
}
