<?php
namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CinemaControllerTest extends WebTestCase
{
    public function testProgrammationPageAccessible()
    {
        $client = static::createClient();
        $client->request('GET', '/programmation');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Programmation');
    }
}
