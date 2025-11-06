<?php
namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfilControllerTest extends WebTestCase
{
    public function testProfilPageRedirectIfNotLoggedIn()
    {
        $client = static::createClient();
        $client->request('GET', '/profil');
        $this->assertResponseRedirects('/login');
    }
}
