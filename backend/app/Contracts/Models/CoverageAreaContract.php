<?php

namespace App\Contracts\Models;

interface CoverageAreaContract
{
    public const TABLE = 'coverage_areas';
    public const ID = 'id';
    public const PARTNER = 'partner_id';
    public const COVERAGE = 'coverage';
    public const COVERAGE_ID = self::COVERAGE . '_id';
    public const COVERAGE_TYPE = self::COVERAGE . '_type';
}
