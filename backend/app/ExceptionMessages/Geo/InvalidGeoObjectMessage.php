<?php

namespace App\ExceptionMessages\Geo;

use App\ExceptionMessages\ExceptionMessageInterface;
use App\ValueObjects\GeoValues\GeoObjectInterface;

class InvalidGeoObjectMessage implements ExceptionMessageInterface
{
    public function __construct(private GeoObjectInterface $object)
    {
    }

    public function __toString(): string
    {
        return sprintf(
            'given "%s" type is not known.',
            $this->object->getType()
        );
    }
}
