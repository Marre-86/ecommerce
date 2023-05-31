<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spectator\Spectator;
use Illuminate\Testing\Fluent\AssertableJson;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Spectator::using('openapi.yaml');

        $this->seed();
    }

    public function testGetAllProducts(): void
    {
        $response = $this->get('/api/v1/products');

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 24, fn (AssertableJson $json) =>
                        $json->where('id', 1)
                            ->where('name', 'ANRABESS Casual Loose Short Sleeve Long Dress')
                            ->etc())
                    ->etc())
            ->assertValidResponse(200);
    }

    public function testSearchQueryNamePriceGTE(): void
    {
        $response = $this->get('/api/v1/products?filter[name]=dress&filter[price-gte]=100');

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 3, fn (AssertableJson $json) =>
                        $json->where('id', 15)
                            ->where('name', 'Dress the Population Women\'s Dress')
                            ->etc())
                    ->etc())
            ->assertValidResponse(200);
    }

    public function testSearchQueryPriceLTE(): void
    {
        $response = $this->get('/api/v1/products?filter[price-lte]=40');

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 12, fn (AssertableJson $json) =>
                        $json->where('id', 1)
                            ->where('name', 'ANRABESS Casual Loose Short Sleeve Long Dress')
                            ->etc())
                    ->etc())
            ->assertValidResponse(200);
    }

    public function testSearchQueryWeight(): void
    {
        $response = $this->get('/api/v1/products?filter[weight]=0.74');

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 1, fn (AssertableJson $json) =>
                        $json->where('id', 4)
                            ->where('name', 'DREAM PAIRS Women\'s High Stilettos Heels')
                            ->etc())
                    ->etc())
            ->assertValidResponse(200);
    }

    public function testSearchQueryLengthWidth(): void
    {
        $response = $this->get('/api/v1/products?filter[length]=0.26&filter[width]=0.28');

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 1, fn (AssertableJson $json) =>
                        $json->where('id', 24)
                            ->where('name', 'Disney Girls Toddler Winter Hat and Mittens Set Ages 2-4')
                            ->etc())
                    ->etc())
            ->assertValidResponse(200);
    }

    public function testSearchQueryCategoryId(): void
    {
        $response = $this->get('/api/v1/products?filter[category_id]=7');

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 4, fn (AssertableJson $json) =>
                        $json->where('id', 7)
                            ->where('name', 'Amazon Essentials Women\'s Buckle Mule')
                            ->etc())
                    ->etc())
            ->assertValidResponse(200);
    }

    public function testSearchQueryNoMatches(): void
    {
        $response = $this->get('/api/v1/products?filter[name]=valera');

        $response
            ->assertJson(['message' => 'No items with these parameters.'])
            ->assertValidResponse(200);
    }
}
