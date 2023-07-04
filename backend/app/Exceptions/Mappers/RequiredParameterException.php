<?php

namespace App\Exceptions\Mappers;

use App\Traits\Exceptions\HasThrowIfTrait;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RequiredParameterException extends HttpException
{
    use HasThrowIfTrait;
}
