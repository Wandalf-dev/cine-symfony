<?php

namespace App\Controller;

use App\Entity\Film;
use App\Repository\FilmRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CinemaController extends AbstractController
{
    #[Route('/programmation', name: 'app_programmation')]
    public function programmation(FilmRepository $filmRepository): Response
    {
        $films = $filmRepository->findAll();
        return $this->render('cinema/programmation.html.twig', [
            'films' => $films
        ]);
    }
    #[Route('/profil', name: 'app_profil')]
    public function profil(ReservationRepository $reservationRepository): Response
    {
        $user = $this->getUser();
        $reservations = $user ? $reservationRepository->findBy(['utilisateur' => $user]) : [];
        return $this->render('cinema/reservations.html.twig', [
            'reservations' => $reservations,
        ]);
    }
        #[Route('/reservation/{id}/annuler', name: 'app_reservation_annuler', methods: ['POST'])]
        public function annulerReservation(int $id, ReservationRepository $reservationRepository): Response
        {
            $reservation = $reservationRepository->find($id);
            $user = $this->getUser();
            if (!$reservation || !$user || $reservation->getUtilisateur() !== $user) {
                throw $this->createNotFoundException('Réservation non trouvée ou accès interdit.');
            }
            $reservation->setStatut(\App\Enum\StatutReservation::ANNULE);
            $reservationRepository->getEntityManager()->flush();
            return $this->redirectToRoute('app_profil');
        }
}
