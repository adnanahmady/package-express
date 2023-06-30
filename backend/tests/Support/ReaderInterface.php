<?php

namespace Tests\Support;

use Illuminate\Support\Collection;

interface ReaderInterface
{
    public function read(string $file = null): Collection;
}
