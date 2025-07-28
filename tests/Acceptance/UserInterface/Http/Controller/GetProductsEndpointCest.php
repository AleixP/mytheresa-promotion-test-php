<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\UserInterface\Http\Controller;

use App\Tests\Support\AcceptanceTester;
use PHPUnit\Framework\Assert;

final class GetProductsEndpointCest
{
    private const ENDPOINT_URL = 'products';

    private function getResponseSchema(): array
    {
        return [
            'data' => [
                [
                    'sku' => 'string',
                    'name' => 'string',
                    'category' => 'string',
                    'price' => [
                        'original' => 'integer',
                        'final' => 'integer',
                        'discount_percentage' => 'string|null',
                        'currency' => 'string'
                    ]
                ]
            ],
            'total' => 'integer',
            'page' => 'integer',
            'limit' => 'integer'
        ];
    }
    public function testGetProductsEndpointWithoutFiltersReturnJsonListOfProducts(AcceptanceTester $I): void
    {
        $I->wantTo("Given a valid api call with no filters " .
            "Then I should receive 5 items per page inside data key"
        );
        $url = self::ENDPOINT_URL. '?page=1';
        $I->sendGet($url);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson();

        $data = json_decode($I->grabResponse(), true);
        Assert::assertCount(5, $data['data']);
        $I->seeResponseMatchesJsonType($this->getResponseSchema());
    }

    public function testGetProductsEndpointWithFilterBootsReturnJsonListOfProducts(AcceptanceTester $I): void
    {
        $I->wantTo("Given a valid api call with category = boots " .
            "Then I should receive 3 items per page inside data key"
        );
        $url = self::ENDPOINT_URL. '?page=1&category=boots';
        $I->sendGet($url);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson();

        $data = json_decode($I->grabResponse(), true);
        Assert::assertCount(3, $data['data']);
        $I->seeResponseMatchesJsonType($this->getResponseSchema());
    }

    public function testGetProductsEndpointWithFilterInvalidCategoryReturnBadRequest(AcceptanceTester $I): void
    {
        $I->wantTo("Given a valid api call with category = invalid " .
            "Then I should receive a 400 status code"
        );
        $url = self::ENDPOINT_URL. '?page=1&category=invalid';

        $I->sendGet($url);
        $I->seeResponseCodeIs(400);
    }
}
