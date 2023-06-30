<?php

namespace App\Http\Requests\Api\V1\Partners\Store;

interface StoreContract
{
    public const ID = 'id';
    public const DOCUMENT = 'document';
    public const OWNER_NAME = 'ownerName';
    public const TRADING_NAME = 'tradingName';
    public const ADDRESS = 'address';
    public const COVERAGE_AREA = 'coverageArea';
}
