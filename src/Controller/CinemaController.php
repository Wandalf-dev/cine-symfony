<?php

namespace App\Controller;

use App\Entity\Film;
use App\Repository\FilmRepository;
use App\Repository\ReservationRepository;
use App\Repository\SeanceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CinemaController extends AbstractController
{
    #[Route('/seance/{id}/reserver', name: 'app_reservation_create', methods: ['POST'])]
    public function reserver(int $id, Request $request, SeanceRepository $seanceRepository, ReservationRepository $reservationRepository): Response
    {
        $seance = $seanceRepository->find($id);
        $user = $this->getUser();
        $nbPlaces = $request->request->get('nombre_places');

        if (!$seance || !$user || !$nbPlaces || $nbPlaces < 1) {
            return $this->redirectToRoute('app_programmation');
        }

        $reservation = new \App\Entity\Reservation();
        $reservation->setSeance($seance)
            ->setUtilisateur($user)
            ->setNombrePlaces($nbPlaces)
            ->setStatut(\App\Enum\StatutReservation::CONFIRME);

        $reservationRepository->getEntityManager()->persist($reservation);
        $reservationRepository->getEntityManager()->flush();

        return $this->redirectToRoute('app_profil');
    }
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
    $reservations = $user ? $reservationRepository->findBy(['utilisateur' => $user], ['seance' => 'ASC']) : [];
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
