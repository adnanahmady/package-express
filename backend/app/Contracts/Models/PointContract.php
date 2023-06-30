<?php

namespace App\Contracts\Models;

interface PointContract extends CoordinationContract
{
    public const TABLE = 'points';
    public const ID = 'id';
}
