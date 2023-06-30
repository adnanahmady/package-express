<?php

namespace App\ExceptionMessages;

interface ExceptionMessageInterface
{
    public function __toString(): string;
}
