<?php

namespace App\Contracts\Models;

interface AddressContract
{
    public const TABLE = 'addresses';
    public const ID = 'id';
    public const PARTNER = 'partner_id';
    public const COORDINATION = 'coordination';
    public const COORDINATION_ID = self::COORDINATION . '_id';
    public const COORDINATION_TYPE = self::COORDINATION . '_type';
}
