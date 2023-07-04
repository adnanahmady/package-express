<?php

namespace Tests\Unit\Mapper;

use App\ExceptionMessages\Mappers\RequiredParametersMessage;
use App\ExceptionMessages\Mappers\UnknownParameterMessage;
use App\ExceptionMessages\ValueValidtors\InvalidValueMessage;
use App\Exceptions\Mappers\RequiredParameterException;
use App\Exceptions\Mappers\UnknownParameterException;
use App\Support\ApiMappers\AbstractMapper;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class AbstractMapperTest extends TestCase
{
    public function test_it_should_show_proper_exception_for_unknown_parameters(): void
    {
        $this->withoutExceptionHandling();
        $params = [
            'longitude' => 10.343,
            $key = 'invalid-param' => 'value'
        ];
        $mapper = $this->getMapper($params);

        $this->expectException(UnknownParameterException::class);
        $this->expectExceptionMessage(new UnknownParameterMessage($key));

        $mapper->getParams();
    }

    public function test_it_should_let_handler_to_handle_property(): void
    {
        $this->withoutExceptionHandling();
        $params = ['longitude' => 10.343, 'type' => 'invalid'];
        $mapper = $this->getMapper($params);

        $this->expectException(HttpException::class);

        $mapper->getParams();
    }

    public function test_it_should_be_able_to_validate_required_parameters(): void
    {
        $this->withoutExceptionHandling();
        $params = ['latitude' => 10.343];
        $mapper = $this->getMapper($params);

        $this->expectException(RequiredParameterException::class);
        $this->expectExceptionMessage(
            new RequiredParametersMessage(['longitude'])
        );

        $mapper->getParams();
    }

    public function test_it_should_only_show_passed_parameters_and_not_all_reserved_once(): void
    {
        $params = [
            'latitude' => $lat = 10.343,
            'longitude' => $lon = 33.343,
        ];

        $mapper = $this->getMapper($params);

        $this->assertSame([
            'lat' => $lat,
            'lon' => $lon,
        ], $mapper->getParams());
    }

    public function test_it_should_be_able_to_map_given_parameters_to_expected(): void
    {
        $params = [
            'latitude' => $lat = 10.343,
            'longitude' => $lon = 33.343,
        ];

        $mapper = $this->getMapper($params);

        $this->assertSame([
            'lat' => $lat,
            'lon' => $lon,
        ], $mapper->getParams());
    }

    private function getMapper(array $params): AbstractMapper
    {
        return new class ($params) extends AbstractMapper {
            protected array $map = [
                'latitude' => 'lat',
                'longitude' => 'lon',
                'type' => 'mode',
            ];

            protected array $required = [
                'longitude'
            ];

            protected function type(string $type): string
            {
                throw new HttpException(
                    500,
                    new InvalidValueMessage([$type])
                );
            }
        };
    }
}
