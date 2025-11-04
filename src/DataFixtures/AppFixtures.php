<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Film;
use App\Entity\Salle;
use App\Entity\Seance;
use App\Entity\Reservation;
use App\Enum\StatutReservation;
use App\Entity\Utilisateur;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

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


        // Création de 10 utilisateurs
        $utilisateurs = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new Utilisateur();
            $user->setEmail($faker->unique()->safeEmail())
                ->setRoles(['ROLE_USER']);
            $hashed = $this->hasher->hashPassword($user, 'password');
            $user->setPassword($hashed);
            $manager->persist($user);
            $utilisateurs[] = $user;
        }

        // Création de 100 réservations, chaque utilisateur en reçoit quelques-unes
        for ($i = 0; $i < 100; $i++) {
            $reservation = new Reservation();
            $reservation
                ->setNombrePlaces($faker->numberBetween(1, 10))
                ->setStatut(StatutReservation::CONFIRME)
                ->setSeance($seances[array_rand($seances)])
                ->setUtilisateur($utilisateurs[array_rand($utilisateurs)]);
            $manager->persist($reservation);
        }

        $manager->flush();
    }
}