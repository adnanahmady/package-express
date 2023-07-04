<?php

namespace App\Support\ApiMappers;

use App\ExceptionMessages\Mappers\RequiredParametersMessage;
use App\ExceptionMessages\Mappers\UnknownParameterMessage;
use App\Exceptions\Mappers\RequiredParameterException;
use App\Exceptions\Mappers\UnknownParameterException;

abstract class AbstractMapper
{
    /**
     * Expected parameter to mapped parameter names.
     *
     * @var array<string,string>
     */
    protected array $map = [];

    /**
     * Required parameter names.
     *
     * @var array<string>
     */
    protected array $required = [];

    public function __construct(private readonly array $params)
    {
    }

    public function getParams(): array
    {
        $this->validate();
        $map = $this->mapParams();

        return $this->removeMissing($map);
    }

    private function prepareMap(): array
    {
        return array_map(
            fn ($v) => new MissingParameter(),
            array_flip($this->map)
        );
    }

    private function mapParams(): array
    {
        $map = $this->prepareMap();

        foreach ($this->params as $key => $param) {
            UnknownParameterException::throwIf(
                !key_exists($key, $this->map),
                new UnknownParameterMessage($key)
            );
            $map[$this->map[$key]] = $this->handle($key, $param);
        }

        return $map;
    }

    private function removeMissing(array $map): array
    {
        return array_filter(
            $map,
            fn ($v) => !is_a($v, MissingParameter::class)
        );
    }

    private function validate(): void
    {
        $fields = array_diff(
            $this->required,
            array_keys($this->params)
        );

        RequiredParameterException::throwIf(
            count($fields),
            new RequiredParametersMessage($fields)
        );
    }

    private function handle(string $key, mixed $param): mixed
    {
        return method_exists($this, $key) ? $this->{$key}($param) : $param;
    }
}
