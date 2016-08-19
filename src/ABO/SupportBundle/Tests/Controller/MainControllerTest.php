<?php

namespace ABO\SupportBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();

        $client->request('GET', '/');
    }

    public function testHelp()
    {
        $client = static::createClient();

        $client->request('GET', '/help-center');
    }

    public function testGuide()
    {
        $client = static::createClient();

        $client->request('GET', '/buyer-guide');
    }

    public function testStory()
    {
        $client = static::createClient();

        $client->request('GET', '/story');
    }

}
