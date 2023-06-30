<?php

namespace App\Support\Values;

class SridValue implements ValueInterface
{
    public function __toString(): string
    {
        return 4326;
    }
}
