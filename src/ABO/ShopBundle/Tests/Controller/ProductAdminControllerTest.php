<?php

namespace ABO\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductAdminControllerTest extends WebTestCase
{
    public function testAddprodshop()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop/add_prod_shop/{id}');
    }

    public function testProduct()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop/product/{slug}');
    }

    public function testProductajax()
    {
        $client = static::createClient();

        $client->request('GET', 'myShop/product_ajax/{id}');
    }

    public function testAllproducts()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop/all_products');
    }

    public function testProdbycategory()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop/category/{slug}');
    }

    public function testProdbycollection()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop/collection/{slug}');
    }

    public function testAdd()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop/product/new');
    }
}
