<?php

namespace App\Service;

use App\Entity\Seance;

class ReservationService
{
    /**
     * Retourne le nombre total de places réservées (confirmées) pour une séance donnée
     */
    public function getPlacesReservees(Seance $seance): int
    {
        $total = 0;
        foreach ($seance->getReservations() as $reservation) {
            if (method_exists($reservation, 'getStatut') && $reservation->getStatut() && $reservation->getStatut()->value === 'Confirmé') {
                $total += $reservation->getNombrePlaces();
            }
        }
        return $total;
    }

    /**
     * Retourne true si la séance est complète (toutes les places sont réservées)
     */
    public function isSeanceComplete(Seance $seance): bool
    {
        $salle = $seance->getSalle();
        if (!$salle || $salle->getCapacite() === null) {
            return false;
        }
        return $this->getPlacesReservees($seance) >= $salle->getCapacite();
    }
}
