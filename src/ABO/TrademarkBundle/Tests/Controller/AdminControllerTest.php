<?php

namespace ABO\TrademarkBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testRegister()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/new_tm');
    }

    public function testArrangement()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/tm/{slug}/arrangements');
    }

    public function testSetcategories()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/tm/{slug}/categories');
    }

    public function testSetting()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/tm/{slug}/setting');
    }
}
