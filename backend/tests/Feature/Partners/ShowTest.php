<?php

namespace Tests\Feature\Partners;

use App\Models\Partner;
use App\Repositories\PartnerRepository;
use App\ValueObjects\GeoValues\AddressGeo;
use App\ValueObjects\GeoValues\CoverageAreaGeo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_response_with_proper_status_code(): void
    {
        $partner = $this->createPartner();

        $response = $this->request($partner);

        $response->assertOk();
    }

    private function request(Partner $partner): TestResponse
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
            new AddressGeo($data['address']),
            new CoverageAreaGeo($data['coverageArea']),
        );
    }

    private function getData(): array
    {
        return jsonReader('Partners/rawData')->read()->first();
    }
}
