<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Film;
use App\Entity\Salle;
use App\Entity\Seance;
use App\Entity\Reservation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $genres = ['Action', 'Aventure', 'Comédie', 'Drame', 'Horreur', 'Science Fiction', 'Romance'];
        $langues = ['Français', 'Anglais', 'Espagnol', 'Allemand', 'Italien', 'Japonais', 'Chinois'];

        $films = [];
        for ($i = 0; $i < 6; $i++) {
            $film = new Film();
            $film
                ->setTitre(ucfirst($faker->word()) . ' ' . ucfirst($faker->word()))
                ->setDuree($faker->numberBetween(60, 200))
                ->setGenre($genres[array_rand($genres)])
                ->setLangue($langues[array_rand($langues)]);
            $manager->persist($film);
            $films[] = $film;
        }

        $salles = [];
        for ($i = 1; $i <= 3; $i++) {
            $salle = new Salle();
            $salle->setNumero($i);
            $manager->persist($salle);
            $salles[] = $salle;
        }

        $seances = [];
        for ($i = 1; $i <= 20; $i++) {
            $seance = new Seance();
            $seance
                ->setDatetime($faker->dateTimeThisMonth())
                ->setSalle($salles[array_rand($salles)])
                ->setFilm($films[array_rand($films)]);
            $manager->persist($seance);
            $seances[] = $seance;
        }

        for ($i = 0; $i < 100; $i++) {
            $reservation = new Reservation();
            $reservation
                ->setNombrePlaces($faker->numberBetween(1, 10))
                ->setStatut(Reservation::STATUT_CONFIRME)
                ->setSeance($seances[array_rand($seances)]);
            $manager->persist($reservation);
        }

        $manager->flush();
    }
}