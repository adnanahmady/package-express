<?php

namespace App\Support\GeoCreator;

use App\Contracts\Models\GisModelInterface;
use App\Repositories\PointRepository;
use App\Support\GeoCreator\Types\PointType;

class PointCreator implements CreatorInterface
{
    public function __construct(private readonly Creator $creator)
    {
    }

    public function create(): GisModelInterface
    {
        if (!$this->creator->object->isA(new PointType())) {
            return $this->getCreator()->create();
        }

        return $this->getRepository()->create(
            $this->creator->object
        );
    }

    private function getRepository(): PointRepository
    {
        return new PointRepository();
    }

    private function getCreator(): CreatorInterface
    {
        return new MultiPolygonCreator($this->creator);
    }
}
