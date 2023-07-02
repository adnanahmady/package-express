<?php

namespace Tests\Feature\Searches;

use App\Http\Requests\Api\V1\Searches\SearchNearestRequest as Request;
use App\Http\Resources\Api\V1\Partners\Show;
use App\Http\Resources\Api\V1\Searches\Nearest;
use App\Models\Partner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class NearestTest extends TestCase
{
    use RefreshDatabase;

    public function test_nearest_point_should_be_returned_as_expected(): void
    {
        $this->withoutExceptionHandling();
        $partnerCreator = new PartnerCreator();
        $partnerCreator->createFarthestPartner();
        $nearestPartner = $partnerCreator->createNearestPartner();
        $partnerCreator->createFarPartner();
        $partnerCreator->createNotCoveringPartner();

        $data = $this->request([
            Request::POINT => [
                Request::LONGITUDE => 51.32373893458865,
                Request::LATITUDE => 35.63148698204205
            ]
        ])->json(join('.', [
            Nearest\PaginatorResource::DATA,
            Show\DataResource::ID,
        ]));

        $this->assertEquals($nearestPartner->getId(), $data);
    }

    public function test_when_no_partner_is_found_an_empty_list_should_be_returned(): void
    {
        $this->withoutExceptionHandling();
        $this->createPartner();

        $response = $this->request([
            Request::POINT => [
                'lon' => 57.72449850721907,
                'lat' => 38.12771944951433
            ]
        ])->json();

        $this->assertCount(0, $response[Nearest\PaginatorResource::DATA]);
        $this->assertArrayNotHasKey(Nearest\PaginatorResource::META, $response);
    }

    public function dataProviderForValidationTest(): array
    {
        return [
            'longitude needs to be int or float' => [[
                Request::POINT => [
                    Request::LONGITUDE => '38/1277',
                    Request::LATITUDE => 38.1277,
                ]
            ]],
            'latitude needs to be int or float' => [[
                Request::POINT => [
                    Request::LONGITUDE => 38.1277,
                    Request::LATITUDE => '38,1277',
                ]
            ]],
            'point should contain latitude' => [[
                Request::POINT => [
                    Request::LONGITUDE => 38.1277,
                ]
            ]],
            'point should contain longitude' => [[
                Request::POINT => [
                    Request::LATITUDE => 38.1277,
                ]
            ]],
            'point should be array' => [[
                Request::POINT => '[lon,lat]'
            ]],
        ];
    }

    /**
     * @dataProvider dataProviderForValidationTest
     *
     * @param array $params Params.
     *
     * @return void
     */
    public function test_validation(array $params): void
    {
        $response = $this->request($params);

        $response->assertUnprocessable();
        $this->assertCount(1, $response->json('errors'));
    }

    public function test_it_should_show_coverage_area_information_as_expected(): void
    {
        $this->withoutExceptionHandling();
        $this->createPartner();

        $data = $this->request([
            Request::POINT => [
                'lon' => 37.72449850721907,
                'lat' => 38.12771944951433
            ]
        ])->json(join('.', [
            Nearest\PaginatorResource::META,
            Show\MetaResource::COVERAGE_AREA,
        ]));

        $this->assertArrayHasKeys([
            Show\CoverageAreaResource::ID,
            Show\CoverageAreaResource::TYPE,
            Show\CoverageAreaResource::COORDINATES,
        ], $data);
    }

    public function test_it_should_show_address_information_as_expected(): void
    {
        $this->withoutExceptionHandling();
        $this->createPartner();

        $data = $this->request([
            Request::POINT => [
                'lon' => 37.72449850721907,
                'lat' => 38.12771944951433
            ]
        ])->json(join('.', [
            Nearest\PaginatorResource::META,
            Show\MetaResource::ADDRESS,
        ]));

        $this->assertArrayHasKeys([
            Show\AddressResource::ID,
            Show\AddressResource::TYPE,
            Show\AddressResource::COORDINATES,
        ], $data);
    }

    public function test_it_should_response_in_expected_form(): void
    {
        $this->createPartner();

        $data = $this->request([
            Request::POINT => [
                'lon' => 37.72449850721907,
                'lat' => 38.12771944951433
            ]
        ])->json(Nearest\PaginatorResource::DATA);

        $this->assertIsString($data[Show\DataResource::ID]);
        $this->assertIsString($data[Show\DataResource::OWNER_NAME]);
        $this->assertIsString($data[Show\DataResource::TRADING_NAME]);
        $this->assertIsString($data[Show\DataResource::DOCUMENT]);
        $this->assertIsInt($data[Show\DataResource::ADDRESS]);
        $this->assertIsInt($data[Show\DataResource::COVERAGE_AREA]);
    }

    public function test_it_should_find_nearest_partner_based_on_given_point(): void
    {
        $this->withoutExceptionHandling();
        $this->createPartner();

        $response = $this->request([
            Request::POINT => [
                'lon' => 37.72449850721907,
                'lat' => 38.12771944951433
            ]
        ])->json();

        $this->assertCount(6, $response[Nearest\PaginatorResource::DATA]);
        $this->assertCount(2, $response[Nearest\PaginatorResource::META]);
    }

    public function test_when_no_parameters_are_set_the_proper_message_should_be_given(): void
    {
        $response = $this->request();

        $this->assertArrayNotHasKey(Nearest\PaginatorResource::DATA, $response);
        $this->assertSame([
            Nearest\NoFilterResponse::MESSAGE => 'You should be able set an enquiry.'
        ], $response[Nearest\NoFilterResponse::META]);
    }

    public function test_it_should_response_with_proper_status_code(): void
    {
        $response = $this->request();

        $response->assertOk();
    }

    private function request(array $params = []): TestResponse
    {
        return $this->getJson(route(
            name: 'api.v1.searches.nearest',
            parameters: $params
        ));
    }

    private function createPartner(
        string $id = null,
        array $address = null,
        array $coverageArea = null,
    ): Partner {
        return (new PartnerCreator())->createPartner(
            id: $id,
            address: $address,
            coverageArea: $coverageArea
        );
    }
}
