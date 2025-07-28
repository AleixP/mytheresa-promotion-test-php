<?php

namespace App\Tests\Acceptance\UserInterface\Http\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class GetProductsTest extends WebTestCase
{
    private const ENDPOINT = '/products';

    public function testGetProductsEndpointWithoutFiltersReturnJsonListOfProducts(): void
    {
        $client = static::createClient();
        $client->request('GET', self::ENDPOINT, ['page' => 1]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
    }
}
