<?php

namespace Tests\Unit\OpenWeather;

use App\Api\OpenWeather\Weather;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\Support\ReaderInterface;
use Tests\TestCase;

class WeatherTest extends TestCase
{
    public function test_the_response_should_be_as_expected(): void
    {
        $weather = new Weather([
            'longitude' => 10.22,
            'latitude' => 11.33,
        ]);

        $data = $weather->get();

        $this->assertSame(
            $this->getReader()->read('general')->toArray(),
            $data
        );
    }

    public function test_it_should_call_the_endpoint_with_specified_parameters(): void
    {
        $appid = config('api.open_weather.apikey');
        $weather = new Weather([
            'longitude' => $lon = 10.22,
            'latitude' => $lat = 11.33,
        ]);

        $weather->get();

        Http::assertSent(fn (Request $request) => str_contains(
            $request->url(),
            "/data/2.5/weather?appid={$appid}&lon={$lon}&lat={$lat}"
        ));
    }

    public function test_it_should_request_for_data_from_correct_endpoint(): void
    {
        $weather = new Weather(['longitude' => 10.22, 'latitude' => 11.33]);

        $weather->get();

        Http::assertSent(fn (Request $request) => str_contains(
            $request->url(),
            '/data/2.5/weather'
        ));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $general = $this->getReader()->read('general');
        Http::fake([
            '/data/2.5/weather*' => Http::response($general)
        ]);
    }

    private function getReader(): ReaderInterface
    {
        return jsonReader('Api/OpenWeather');
    }
}
