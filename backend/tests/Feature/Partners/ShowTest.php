<?php

namespace Tests\Feature\Partners;

use App\Http\Resources\Api\V1\Partners\Show;
use App\Models\Partner;
use App\Repositories\PartnerRepository;
use App\ValueObjects\GeoValues\MultiPolygonObject;
use App\ValueObjects\GeoValues\PointObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_show_coverage_area_information_as_expected(): void
    {
        $this->withoutExceptionHandling();
        $partner = $this->createPartner();

        $data = $this->request($partner)->json(join('.', [
            Show\PaginatorResource::META,
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
        $partner = $this->createPartner();

        $data = $this->request($partner)->json(join('.', [
            Show\PaginatorResource::META,
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
        $partner = $this->createPartner();

        $data = $this->request($partner)->json(
            Show\PaginatorResource::DATA
        );

        $this->assertIsString($data[Show\DataResource::ID]);
        $this->assertIsString($data[Show\DataResource::OWNER_NAME]);
        $this->assertIsString($data[Show\DataResource::TRADING_NAME]);
        $this->assertIsString($data[Show\DataResource::DOCUMENT]);
        $this->assertIsInt($data[Show\DataResource::ADDRESS]);
        $this->assertIsInt($data[Show\DataResource::COVERAGE_AREA]);
    }

    public function test_given_id_should_exist_in_system(): void
    {
        $response = $this->request(1);

        $response->assertNotFound();
    }

    public function test_it_should_response_with_proper_status_code(): void
    {
        $partner = $this->createPartner();

        $response = $this->request($partner);

        $response->assertOk();
    }

    private function request(mixed $partner): TestResponse
    {
        return $this->getJson(route('api.v1.partners.show', $partner));
    }

    private function createPartner(): Partner
    {
        $data = $this->getData();

        return (new PartnerRepository())->create(
            $data['id'],
            $data['document'],
            $data['ownerName'],
            $data['tradingName'],
            PointObject::initiateFromArray($data['address']),
            MultiPolygonObject::initiateFromArray($data['coverageArea']),
        );
    }

    private function getData(): array
    {
        return jsonReader('Partners/rawData')->read()->first();
    }
}
