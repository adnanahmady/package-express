<?php

namespace App\Exceptions\Mappers;

use App\Traits\Exceptions\HasThrowIfTrait;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UnknownParameterException extends HttpException
{
    use HasThrowIfTrait;
}
