<?php

namespace App\ExceptionMessages\ValueValidtors;

use App\ExceptionMessages\ExceptionMessageInterface;

class InvalidValueMessage implements ExceptionMessageInterface
{
    public function __construct(private readonly array $values)
    {
    }

    public function __toString(): string
    {
        return sprintf(
            'only the following fields are valid: %s',
            json_encode($this->values)
        );
    }
}
