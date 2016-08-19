<?php

namespace ABO\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testSetting()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop/setting');
    }

    public function testSettingajax()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop/setting_ajax');
    }

    public function testSetcategories()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop/categories');
    }

    public function testCollections()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop/collections');
    }

    public function testPayments()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop/payments');
    }

    public function testRemoveccpp()
    {
        $client = static::createClient();

        $client->request('GET', 'myShop/remove/{rmv}/{id}');
    }

}
