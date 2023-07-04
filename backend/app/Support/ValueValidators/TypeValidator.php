<?php

namespace App\Support\ValueValidators;

use App\ExceptionMessages\ValueValidtors\InvalidValueMessage;
use App\Exceptions\ValueValidators\InvalidValueException;

class TypeValidator implements ValueValidatorInterface
{
    protected array $types = ['xml', 'html', 'json'];

    public function __construct(private readonly string $type)
    {
    }

    public function validate(): void
    {
        InvalidValueException::throwIf(
            !in_array($this->type, $this->types),
            new InvalidValueMessage($this->types)
        );
    }
}
