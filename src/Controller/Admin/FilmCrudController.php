<?php


namespace App\Controller\Admin;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use App\Entity\Film;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

#[IsGranted('ROLE_ADMIN')]
class FilmCrudController extends AbstractCrudController
{
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            TextField::new('genre'),
            IntegerField::new('duree'),
            TextField::new('langue'),
            ImageField::new('image')
                ->setUploadDir('public/uploads')
                ->setBasePath('uploads'),
        ];
    }
    public static function getEntityFqcn(): string
    {
        return Film::class;
    }

}

