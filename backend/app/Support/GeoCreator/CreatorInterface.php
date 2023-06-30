<?php

namespace App\Support\GeoCreator;

use App\Contracts\Models\GisModelInterface;

interface CreatorInterface
{
    public function create(): GisModelInterface;
}
