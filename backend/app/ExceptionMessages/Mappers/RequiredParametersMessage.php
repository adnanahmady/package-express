<?php

namespace App\ExceptionMessages\Mappers;

use App\ExceptionMessages\ExceptionMessageInterface;

class RequiredParametersMessage implements ExceptionMessageInterface
{
    public function __construct(private readonly array $fields)
    {
    }

    public function __toString(): string
    {
        return sprintf(
            'fields in the following list are required: %s',
            json_encode($this->fields)
        );
    }
}
