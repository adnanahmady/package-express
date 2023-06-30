<?php

namespace Tests\Feature\Partners;

use App\Contracts\Models\AddressContract;
use App\Contracts\Models\CoverageAreaContract;
use App\Contracts\Models\MultiPolygonContract;
use App\Contracts\Models\PartnerContract;
use App\Contracts\Models\PointContract;
use App\Http\Requests\Api\V1\Partners\Store\StoreContract;
use App\Http\Resources\Api\V1\Partners\Stored;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function dataProviderForValidationTest(): array
    {
        return [
            'Partner should present array as coordinates for coverage area' => [
                function (array $data) {
                    $data['coverageArea']['coordinates'] = 'string';

                    return $data;
                }
            ],
            'Partner should present coordinates for coverage area' => [
                function (array $data) {
                    unset($data['coverageArea']['coordinates']);

                    return $data;
                }
            ],
            'Partner should present a type for coverage area' => [
                function (array $data) {
                    unset($data['coverageArea']['type']);

                    return $data;
                }
            ],
            'Partner should not present coordinates with more than three values for address' => [
                function (array $data) {
                    $data['address']['coordinates'] = [1, 2, 3, 4];

                    return $data;
                }
            ],
            'Partner should present coordinates with at least two values for address' => [
                function (array $data) {
                    $data['address']['coordinates'] = [1];

                    return $data;
                }
            ],
            'Partner should present coordinates for address' => [
                function (array $data) {
                    unset($data['address']['coordinates']);

                    return $data;
                }
            ],
            'Partner should present a type for address' => [
                function (array $data) {
                    unset($data['address']['type']);

                    return $data;
                }
            ],
            'Partner should present a document for its request' => [
                function (array $data) {
                    unset($data['document']);

                    return $data;
                }
            ],
            'Partner should present a trading name for its request' => [
                function (array $data) {
                    unset($data['tradingName']);

                    return $data;
                }
            ],
            'Partner should present a owner name for its request' => [
                function (array $data) {
                    unset($data['ownerName']);

                    return $data;
                }
            ],
            'Partner should present an id for its request' => [
                function (array $data) {
                    unset($data['id']);

                    return $data;
                }
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForValidationTest
     *
     * @param callable $fn Handler.
     *
     * @return void
     */
    public function test_data_validation(callable $fn): void
    {
        $data = $fn($this->getData());

        $response = $this->request(data: $data);

        $response->assertUnprocessable();
        $this->assertCount(1, $response->json('errors'));
    }

    public function dataProviderForUniqueFieldValidationTest(): array
    {
        return [
            'Partner can only present unique document' => [
                function (array $data) {
                    $data['id'] = random_int(1, 133333);

                    return $data;
                }
            ],
            'Partner can only present unique id' => [
                function (array $data) {
                    $data['document'] = random_int(1, 133333);

                    return $data;
                }
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForUniqueFieldValidationTest
     *
     * @param callable $fn Handler.
     *
     * @return void
     */
    public function test_unique_field_validation(callable $fn): void
    {
        $request = $this->getData();
        $this->request(data: $fn($request));

        $response = $this->request(data: $fn($request));

        $response->assertUnprocessable();
        $this->assertCount(1, $response->json('errors'));
    }

    /**
     * @group slow
     *
     * @return void
     */
    public function test_all_partner_data_should_be_installed_without_any_problem(): void
    {
        $this->withoutExceptionHandling();
        $partners = jsonReader('Partners/rawData')->read();

        foreach($partners as $partner) {
            $this->request(data: $partner);
        }

        $count = $partners->count();
        $this->assertDatabaseCount(PartnerContract::TABLE, $count);
        $this->assertDatabaseCount(AddressContract::TABLE, $count);
        $this->assertDatabaseCount(PointContract::TABLE, $count);
        $this->assertDatabaseCount(MultiPolygonContract::TABLE, $count);
        $this->assertDatabaseCount(CoverageAreaContract::TABLE, $count);
    }

    public function test_it_should_show_coverage_area_information_as_expected(): void
    {
        $this->withoutExceptionHandling();
        $request = $this->getData();

        $data = $this->request(data: $request)->json(join('.', [
            Stored\PaginatorResource::META,
            Stored\MetaResource::COVERAGE_AREA,
        ]));

        $this->assertArrayHasKeys([
            Stored\CoverageAreaResource::ID,
            Stored\CoverageAreaResource::TYPE,
            Stored\CoverageAreaResource::COORDINATES,
        ], $data);
    }

    public function test_it_should_show_address_information_as_expected(): void
    {
        $this->withoutExceptionHandling();
        $request = $this->getData();

        $data = $this->request(data: $request)->json(join('.', [
            Stored\PaginatorResource::META,
            Stored\MetaResource::ADDRESS,
        ]));

        $this->assertArrayHasKeys([
            Stored\AddressResource::ID,
            Stored\AddressResource::TYPE,
            Stored\AddressResource::COORDINATES,
        ], $data);
    }

    public function test_it_should_response_with_proper_format(): void
    {
        $this->withoutExceptionHandling();
        $request = $this->getData();

        $data = $this->request(data: $request)->json(Stored\PaginatorResource::DATA);

        $this->assertIsString($data[Stored\DataResource::ID]);
        $this->assertIsString($data[Stored\DataResource::OWNER_NAME]);
        $this->assertIsString($data[Stored\DataResource::TRADING_NAME]);
        $this->assertIsString($data[Stored\DataResource::DOCUMENT]);
        $this->assertIsInt($data[Stored\DataResource::ADDRESS]);
        $this->assertIsInt($data[Stored\DataResource::COVERAGE_AREA]);
    }

    public function test_it_should_store_the_partner_data_in_database(): void
    {
        $this->withoutExceptionHandling();
        $data = $this->getData();

        $this->request(data: $data);

        $this->assertDatabaseHas(PartnerContract::TABLE, [
            PartnerContract::ID => $data[StoreContract::ID],
            PartnerContract::DOCUMENT => $data[StoreContract::DOCUMENT],
            PartnerContract::OWNER_NAME => $data[StoreContract::OWNER_NAME],
            PartnerContract::TRADING_NAME => $data[
                StoreContract::TRADING_NAME
            ],
        ]);
        $this->assertDatabaseCount(AddressContract::TABLE, 1);
        $this->assertDatabaseCount(PointContract::TABLE, 1);
        $this->assertDatabaseCount(MultiPolygonContract::TABLE, 1);
        $this->assertDatabaseCount(CoverageAreaContract::TABLE, 1);
    }

    public function test_it_should_response_with_proper_status_code(): void
    {
        $this->withoutExceptionHandling();
        $data = $this->getData();

        $response = $this->request(data: $data);

        $response->assertCreated();
    }

    private function request(array $data): TestResponse
    {
        return $this->postJson(route('api.v1.partners.store'), data: $data);
    }

    private function getData(): mixed
    {
        return jsonReader('Partners/rawData')->read()->first();
    }
}
