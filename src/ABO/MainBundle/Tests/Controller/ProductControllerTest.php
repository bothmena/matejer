<?php

namespace ABO\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testRate()
    {
        $client = static::createClient();

        $client->request('GET', '/product/rating/{id}');
    }

    public function testWishlist()
    {
        $client = static::createClient();

        $client->request('GET', '/product/wish/{id}');
    }

    public function testProduct()
    {
        $client = static::createClient();

        $client->request('GET', '/product/{slug}');
    }

}
