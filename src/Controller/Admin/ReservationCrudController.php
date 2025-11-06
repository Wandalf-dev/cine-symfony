<?php

namespace App\Controller\Admin;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[IsGranted('ROLE_ADMIN')]
class ReservationCrudController extends AbstractCrudController
{
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('statut')->formatValue(fn ($value, $entity) => $value?->value),
            \EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField::new('statut')
                ->setChoices([
                    'Confirmé' => \App\Enum\StatutReservation::CONFIRME,
                    'Annulé' => \App\Enum\StatutReservation::ANNULE,
                ])
                ->formatValue(fn ($value, $entity) => $value?->value),
            \EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField::new('seance'),
            \EasyCorp\Bundle\EasyAdminBundle\Field\TextField::new('seance.film')->setLabel('Film'),
            \EasyCorp\Bundle\EasyAdminBundle\Field\TextField::new('seance.salle')->setLabel('Salle'),
            \EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField::new('seance.datetime')->setLabel('Date'),
            \EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField::new('utilisateur'),
            \EasyCorp\Bundle\EasyAdminBundle\Field\TextField::new('utilisateur.email')->setLabel('Email utilisateur'),
            \EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField::new('nombre_places'),
        ];
    }

    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }
}