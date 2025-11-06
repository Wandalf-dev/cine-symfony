<?php
namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservationWorkflowTest extends WebTestCase
{
    public function testUserCanLoginAndReserveASeance()
    {
        $client = static::createClient();
        // Aller sur la page de login
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        // Remplir et soumettre le formulaire de connexion
        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'admin@cineaurora.fr',
            '_password' => 'admin123'
        ]);
        $client->submit($form);
        $client->followRedirect();
        // Aller sur la page de programmation
        $crawler = $client->request('GET', '/programmation');
        $this->assertResponseIsSuccessful();
        // Trouver le premier formulaire de réservation (si disponible)
        $form = $crawler->filter('form.seance-form')->first();
        if ($form->count() === 0) {
            $this->markTestSkipped('Aucune séance disponible pour réserver.');
        }
        $formNode = $form->form([
            'nombre_places' => 1
        ]);
        $client->submit($formNode);
        $client->followRedirect();
        // Vérifier que la réservation apparaît dans le profil
        $crawler = $client->request('GET', '/profil');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('table.reservations');
        $this->assertSelectorTextContains('table.reservations', 'Confirmé');
    }
}
