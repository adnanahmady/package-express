<?php

namespace Tests\Unit\Mapper;

use App\Exceptions\Mappers\RequiredParameterException;
use App\Exceptions\ValueValidators\InvalidValueException;
use App\Support\ApiMappers\WeatherMapper;
use Tests\TestCase;

class WeatherMapperTest extends TestCase
{
    public function test_the_unit_parameter_should_be_an_acceptable_type(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(InvalidValueException::class);
        $params = [
            'latitude' => 10.343,
            'longitude' => 33.343,
            'type' => 'html',
            'unit' => 'meters',
        ];

        $mapper = new WeatherMapper($params);

        $mapper->getParams();
    }

    public function test_the_type_parameter_should_be_an_acceptable_type(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(InvalidValueException::class);
        $params = [
            'latitude' => 10.343,
            'longitude' => 33.343,
            'type' => 'no-html'
        ];

        $mapper = new WeatherMapper($params);

        $mapper->getParams();
    }

    public function dataProviderForParameterValidation(): array
    {
        return [
            'the latitude should be passed' => [
                ['longitude' => 10.343]
            ],
            'the longitude should be passed' => [
                ['latitude' => 10.343]
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForParameterValidation
     *
     * @param array $params Params.
     *
     * @return void
     */
    public function test_parameter_validation(array $params): void
    {
        $this->withoutExceptionHandling();
        $mapper = new WeatherMapper($params);

        $this->expectException(RequiredParameterException::class);

        $mapper->getParams();
    }

    public function test_it_should_only_show_passed_parameters_and_not_all_reserved_once(): void
    {
        $params = [
            'latitude' => $lat = 10.343,
            'longitude' => $lon = 33.343,
        ];

        $mapper = new WeatherMapper($params);

        $this->assertSame([
            'lon' => $lon,
            'lat' => $lat,
        ], $mapper->getParams());
    }

    public function test_it_should_be_able_to_map_given_parameters_to_expected(): void
    {
        $params = [
            'latitude' => $lat = 10.343,
            'longitude' => $lon = 33.343,
        ];

        $mapper = new WeatherMapper($params);

        $this->assertSame([
            'lon' => $lon,
            'lat' => $lat,
        ], $mapper->getParams());
    }
}
