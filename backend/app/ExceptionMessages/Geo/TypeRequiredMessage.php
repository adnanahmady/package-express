<?php

namespace App\ExceptionMessages\Geo;

use App\ExceptionMessages\ExceptionMessageInterface;

class TypeRequiredMessage implements ExceptionMessageInterface
{
    public function __toString(): string
    {
        return 'Please set the type of Geo json object.';
    }
}
