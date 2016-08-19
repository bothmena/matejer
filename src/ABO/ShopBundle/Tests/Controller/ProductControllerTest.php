<?php

namespace ABO\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testAllproducts()
    {
        $client = static::createClient();

        $client->request('GET', '/shop/{slug}/all_products');
    }

    public function testProdbycategory()
    {
        $client = static::createClient();

        $client->request('GET', 'shop/{slug}/category/{slug_cat}');
    }

    public function testProdbycollection()
    {
        $client = static::createClient();

        $client->request('GET', '/shop/{slug}collection/{slug_col}');
    }

    public function testProduct()
    {
        $client = static::createClient();

        $client->request('GET', '/shop/{slug}/product/{slug_prod}');
    }

}
