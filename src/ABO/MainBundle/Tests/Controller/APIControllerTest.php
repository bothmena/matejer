<?php

namespace ABO\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class APIControllerTest extends WebTestCase
{
    public function testHelpcenter()
    {
        $client = static::createClient();

        $client->request('GET', '/help-center/{group}/{item}');
    }

}
