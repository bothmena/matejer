<?php

namespace ABO\TrademarkBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testAdd()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/tm/{slug}/add');
    }

    public function testAllproducts()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/tm/{slug}/all_products');
    }

    public function testProdbycategory()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/tm/{slug}/category/{slug}');
    }

    public function testProdbyarrangement()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/tm/{slug}/arrangement/{slug}');
    }

    public function testProduct()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/tm/{slug}/product/{slug}');
    }

}
