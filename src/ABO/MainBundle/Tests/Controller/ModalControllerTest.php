<?php

namespace ABO\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ModalControllerTest extends WebTestCase
{
    public function testColor()
    {
        $client = static::createClient();

        $client->request('GET', '/modal/color');
    }

    public function testProductinfo()
    {
        $client = static::createClient();

        $client->request('GET', '/modal/prod_info/{id}');
    }

    public function testProductgallery()
    {
        $client = static::createClient();

        $client->request('GET', '/modal/prod_gallery/{id}');
    }

    public function testProductshopinfo()
    {
        $client = static::createClient();

        $client->request('GET', '/modal/prod_shop_info/{id}');
    }

    public function testProductshopform()
    {
        $client = static::createClient();

        $client->request('GET', '/modal/prod_shop_form/{id}');
    }

}
