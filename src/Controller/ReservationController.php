<?php
namespace App\Controller;

use App\Entity\Film;
use App\Entity\Seance;
use App\Entity\Reservation;
use App\Repository\FilmRepository;
use App\Repository\SeanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(Request $request, FilmRepository $filmRepo, SeanceRepository $seanceRepo, EntityManagerInterface $em): Response
    {
        $films = $filmRepo->findAll();
        $seances = $seanceRepo->findAll();
        $success = false;
        if ($request->isMethod('POST')) {
            $filmId = $request->request->get('film');
            $seanceId = $request->request->get('seance');
            $places = (int)$request->request->get('nombre_places');
            $film = $filmRepo->find($filmId);
            $seance = $seanceRepo->find($seanceId);
            if ($film && $seance && $places > 0) {
                $reservation = new Reservation();
                $reservation->setUtilisateur($this->getUser());
                $reservation->setSeance($seance);
                $reservation->setNombrePlaces($places);
                $reservation->setStatut(\App\Enum\StatutReservation::CONFIRME);
                $em->persist($reservation);
                $em->flush();
                return $this->redirectToRoute('app_profil');
            }
        }
        return $this->render('reservation/index.html.twig', [
            'films' => $films,
            'seances' => $seances,
            'success' => $success
        ]);
    }
}
