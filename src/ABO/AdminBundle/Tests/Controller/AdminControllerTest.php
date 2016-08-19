<?php

namespace ABO\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testDashboard()
    {
        $client = static::createClient();

        $client->request('GET', '/dashboard');
    }

    public function testAddtrademark()
    {
        $client = static::createClient();

        $client->request('GET', '/new_tm');
    }

    public function testAlltrademark()
    {
        $client = static::createClient();

        $client->request('GET', 'all_tm');
    }

    public function testAllshop()
    {
        $client = static::createClient();

        $client->request('GET', 'all_shop');
    }

    public function testAlluser()
    {
        $client = static::createClient();

        $client->request('GET', 'all_user');
    }

    public function testAllproduct()
    {
        $client = static::createClient();

        $client->request('GET', 'all_prod');
    }
}
