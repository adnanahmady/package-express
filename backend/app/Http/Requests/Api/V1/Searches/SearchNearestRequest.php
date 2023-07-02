<?php

namespace App\Http\Requests\Api\V1\Searches;

use App\Http\Requests\Api\AbstractFormRequest;

class SearchNearestRequest extends AbstractFormRequest
{
    public const POINT = 'point';
    public const LONGITUDE = 'lon';
    public const LATITUDE = 'lat';

    public function rules(): array
    {
        return [
            self::POINT => sprintf(
                'array|required_array_keys:%s,%s',
                self::LONGITUDE,
                self::LATITUDE,
            ),
            $this->pointProp(self::LATITUDE) => 'numeric',
            $this->pointProp(self::LONGITUDE) => 'numeric',
        ];
    }

    public function hasPoint(): bool
    {
        return !!$this->{self::POINT};
    }

    public function getPoint(): PointParameter
    {
        return new PointParameter($this->{self::POINT});
    }

    private function pointProp(string $property): string
    {
        return join('.', [self::POINT, $property]);
    }
}
