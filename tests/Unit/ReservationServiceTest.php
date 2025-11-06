<?php

namespace App\Tests\Unit;

use App\Entity\Seance;
use App\Entity\Salle;
use App\Entity\Reservation;
use App\Enum\StatutReservation;
use App\Service\ReservationService;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;

class ReservationServiceTest extends TestCase
{
    public function testGetPlacesReserveesOnlyConfirmed()
    {
        $seance = new Seance();
        $salle = new Salle();
        $salle->setCapacite(100);
        $seance->setSalle($salle);

        $reservation1 = new Reservation();
        $reservation1->setNombrePlaces(3)->setStatut(StatutReservation::CONFIRME);
        $reservation2 = new Reservation();
        $reservation2->setNombrePlaces(2)->setStatut(StatutReservation::ANNULE);
        $reservation3 = new Reservation();
        $reservation3->setNombrePlaces(5)->setStatut(StatutReservation::CONFIRME);

        $seance->getReservations()->add($reservation1);
        $seance->getReservations()->add($reservation2);
        $seance->getReservations()->add($reservation3);

        $service = new ReservationService();
        $this->assertEquals(8, $service->getPlacesReservees($seance));
    }

    public function testIsSeanceCompleteReturnsTrueIfFull()
    {
        $seance = new Seance();
        $salle = new Salle();
        $salle->setCapacite(5);
        $seance->setSalle($salle);

        $reservation = new Reservation();
        $reservation->setNombrePlaces(5)->setStatut(StatutReservation::CONFIRME);
        $seance->getReservations()->add($reservation);

        $service = new ReservationService();
        $this->assertTrue($service->isSeanceComplete($seance));
    }

    public function testIsSeanceCompleteReturnsFalseIfNotFull()
    {
        $seance = new Seance();
        $salle = new Salle();
        $salle->setCapacite(10);
        $seance->setSalle($salle);

        $reservation = new Reservation();
        $reservation->setNombrePlaces(3)->setStatut(StatutReservation::CONFIRME);
        $seance->getReservations()->add($reservation);

        $service = new ReservationService();
        $this->assertFalse($service->isSeanceComplete($seance));
    }

    public function testIsSeanceCompleteReturnsFalseIfNoSalle()
    {
        $seance = new Seance();
        $service = new ReservationService();
        $this->assertFalse($service->isSeanceComplete($seance));
    }
}
