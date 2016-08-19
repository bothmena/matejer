<?php

namespace ABO\TrademarkBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ShowControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/tm/{slug}');
    }

    public function testAbout()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/tm/{slug}/about');
    }

    public function testReviews()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/tm/{slug}/reviews');
    }

}
