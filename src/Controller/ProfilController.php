<?php
namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Reservation;
use App\Enum\StatutReservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        /** @var Utilisateur $user */
        $user = $this->getUser();
        $success = false;
    if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $currentPassword = $request->request->get('current_password');
            $newPassword = $request->request->get('new_password');
            $confirmPassword = $request->request->get('confirm_password');

            if ($email && $email !== $user->getEmail()) {
                $user->setEmail($email);
                $success = true;
            }

            if ($currentPassword || $newPassword || $confirmPassword) {
                if (!$currentPassword || !$newPassword || !$confirmPassword) {
                    $this->addFlash('error', 'Tous les champs mot de passe sont obligatoires pour changer le mot de passe.');
                } elseif (!$hasher->isPasswordValid($user, $currentPassword)) {
                    $this->addFlash('error', 'Le mot de passe actuel est incorrect.');
                } elseif ($newPassword !== $confirmPassword) {
                    $this->addFlash('error', 'Les nouveaux mots de passe ne correspondent pas.');
                } elseif (strlen($newPassword) < 6) {
                    $this->addFlash('error', 'Le nouveau mot de passe doit contenir au moins 6 caractères.');
                } else {
                    $user->setPassword($hasher->hashPassword($user, $newPassword));
                    $success = true;
                }
            }

            if ($success) {
                $em->flush();
                $this->addFlash('success', 'Profil mis à jour avec succès.');
                return $this->redirectToRoute('app_profil', ['_updated' => 1]);
            }
        }
        return $this->render('profil.html.twig', [
            'user' => $user,
            'success' => $success
        ]);
    }

    #[Route('/profil/annuler-reservation/{id}', name: 'app_profil_annuler_reservation', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function annulerReservation(Reservation $reservation, EntityManagerInterface $em): Response
    {
        /** @var Utilisateur $user */
        $user = $this->getUser();
        
        // Vérifier que la réservation appartient à l'utilisateur connecté
        if ($reservation->getUtilisateur() !== $user) {
            throw $this->createAccessDeniedException('Cette réservation ne vous appartient pas.');
        }
        
        // Vérifier que la réservation est confirmée
        if ($reservation->getStatut() !== StatutReservation::CONFIRME) {
            $this->addFlash('error', 'Cette réservation ne peut pas être annulée.');
            return $this->redirectToRoute('app_profil');
        }
        
        // Annuler la réservation
        $reservation->setStatut(StatutReservation::ANNULE);
        $em->flush();
        
        $this->addFlash('success', 'Réservation annulée avec succès.');
        return $this->redirectToRoute('app_profil');
    }
}
