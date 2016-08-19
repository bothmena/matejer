<?php

namespace ABO\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testFavored()
    {
        $client = static::createClient();

        $client->request('GET', '/myProfile/wish_list');
    }

    public function testProdbycategory()
    {
        $client = static::createClient();

        $client->request('GET', '/myProfile/category/{slug}');
    }

    public function testReviews()
    {
        $client = static::createClient();

        $client->request('GET', '/myProfile/product_reviews');
    }
}
