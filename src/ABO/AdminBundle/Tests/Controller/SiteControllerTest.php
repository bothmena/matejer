<?php

namespace ABO\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SiteControllerTest extends WebTestCase
{
    public function testCategories()
    {
        $client = static::createClient();

        $client->request('GET', '/categories');
    }

    public function testPlaces()
    {
        $client = static::createClient();

        $client->request('GET', '/places');
    }

}
