<?php

namespace ABO\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegister()
    {
        $client = static::createClient();

        $client->request('GET', '/myProfile/register_shop');
    }

    public function testRating()
    {
        $client = static::createClient();

        $client->request('GET', '/shop/{slug}/rate');
    }

    public function testSubscribe()
    {
        $client = static::createClient();

        $client->request('GET', '/shop/{slug}/subscribe');
    }

}
