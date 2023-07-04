<?php

namespace App\ExceptionMessages\Mappers;

use App\ExceptionMessages\ExceptionMessageInterface;

class UnknownParameterMessage implements ExceptionMessageInterface
{
    public function __construct(private readonly string $parameter)
    {
    }

    public function __toString(): string
    {
        return sprintf(
            'Given parameter named "%s" is not known.',
            $this->parameter
        );
    }
}
