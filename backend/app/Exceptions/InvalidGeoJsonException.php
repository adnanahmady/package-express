<?php

namespace App\Exceptions;

use App\Traits\Exceptions\HasThrowIfTrait;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidGeoJsonException extends HttpException
{
    use HasThrowIfTrait;
}
