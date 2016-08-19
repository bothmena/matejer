<?php

namespace ABO\SupportBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function testContact()
    {
        $client = static::createClient();

        $client->request('GET', '/contact-us');
    }
}
