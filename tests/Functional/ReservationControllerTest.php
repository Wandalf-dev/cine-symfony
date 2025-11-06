<?php
namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservationControllerTest extends WebTestCase
{
    public function testReservationPageRedirectIfNotLoggedIn()
    {
        $client = static::createClient();
        $client->request('GET', '/reservation');
        $this->assertResponseRedirects('/login');
    }
}
