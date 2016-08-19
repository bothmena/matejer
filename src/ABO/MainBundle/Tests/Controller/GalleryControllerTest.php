<?php

namespace ABO\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GalleryControllerTest extends WebTestCase
{
    public function testGallery()
    {
        $client = static::createClient();

        $client->request('GET', '/gallery/{recherche}');
    }

    public function testGalleryshop()
    {
        $client = static::createClient();

        $client->request('GET', '/gallery_shop/{recherche}/{page}');
    }

    public function testGalleryoffer()
    {
        $client = static::createClient();

        $client->request('GET', '/gallery_offer/{recherche}/{page}');
    }

    public function testGallerytrademark()
    {
        $client = static::createClient();

        $client->request('GET', '/gallery_tm/{recherche}/{page}');
    }

}
