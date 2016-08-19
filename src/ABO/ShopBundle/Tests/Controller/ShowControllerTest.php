<?php

namespace ABO\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ShowControllerTest extends WebTestCase
{
    public function testHomeadmin()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop');
    }

    public function testHome()
    {
        $client = static::createClient();

        $client->request('GET', '/shop/{slug}');
    }

    public function testReviews()
    {
        $client = static::createClient();

        $client->request('GET', '/shop/{slug}/reviews');
    }

    public function testReviewsadmin()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop/reviews');
    }

    public function testAbout()
    {
        $client = static::createClient();

        $client->request('GET', '/shop/{slug}/about');
    }

    public function testAboutadmin()
    {
        $client = static::createClient();

        $client->request('GET', '/myShop/about');
    }

}
