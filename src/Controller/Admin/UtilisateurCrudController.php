<?php


namespace App\Controller\Admin;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[IsGranted('ROLE_ADMIN')]
class UtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            \EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField::new('roles')
                ->setChoices(['Utilisateur' => 'ROLE_USER', 'Administrateur' => 'ROLE_ADMIN'])
                ->allowMultipleChoices()
                ->renderExpanded()
                ->formatValue(function ($value) {
                    if (is_array($value)) {
                        return implode(', ', array_map(function($role) {
                            return $role === 'ROLE_ADMIN' ? 'Administrateur' : ($role === 'ROLE_USER' ? 'Utilisateur' : $role);
                        }, $value));
                    }
                    return $value;
                }),
        ];
    }
}
