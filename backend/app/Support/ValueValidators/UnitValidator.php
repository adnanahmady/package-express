<?php

namespace App\Support\ValueValidators;

use App\ExceptionMessages\ValueValidtors\InvalidValueMessage;
use App\Exceptions\ValueValidators\InvalidValueException;

class UnitValidator implements ValueValidatorInterface
{
    protected array $units = ['standard', 'metric', 'imperial'];

    public function __construct(private readonly string $unit)
    {
    }

    public function validate(): void
    {
        InvalidValueException::throwIf(
            !in_array($this->unit, $this->units),
            new InvalidValueMessage($this->units)
        );
    }
}
