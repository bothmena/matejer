<?php

namespace ABO\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailControllerTest extends WebTestCase
{
    public function testShopconfirmation()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop/confirm_email/{code}');
    }

    public function testUserconfirmation()
    {
        $client = static::createClient();

        $client->request('GET', '/myProfile/confirm_email/{code}');
    }

    public function testChangeusermail()
    {
        $client = static::createClient();

        $client->request('GET', '/myProfile/change_email');
    }

}
