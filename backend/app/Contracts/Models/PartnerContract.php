<?php

namespace App\Contracts\Models;

interface PartnerContract
{
    public const TABLE = 'partners';
    public const ID = 'id';
    public const PRIMARY_KEY = self::ID;
    public const TRADING_NAME = 'trading_name';
    public const OWNER_NAME = 'owner_name';
    public const DOCUMENT = 'document';
}
