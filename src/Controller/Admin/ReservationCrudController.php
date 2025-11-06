<?php

namespace App\Controller\Admin;

use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\Reservation;
use App\Enum\StatutReservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;


#[IsGranted('ROLE_ADMIN')]
class ReservationCrudController extends AbstractCrudController
{
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),

            // 🔹 Un seul champ pour "statut", en ChoiceField
            ChoiceField::new('statut')
                ->setChoices([
                    'Confirmé' => StatutReservation::CONFIRME,
                    'Annulé'   => StatutReservation::ANNULE,
                ]),

            AssociationField::new('seance'),
            TextField::new('seance.film')->setLabel('Film'),
            TextField::new('seance.salle')->setLabel('Salle'),
            DateTimeField::new('seance.datetime')->setLabel('Date'),

            AssociationField::new('utilisateur'),
            TextField::new('utilisateur.email')->setLabel('Email utilisateur'),

            IntegerField::new('nombre_places'),
        ];
    }


    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }
}