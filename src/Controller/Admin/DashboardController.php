<?php
namespace App\Controller\Admin;
use App\Entity\Film;
use App\Entity\Seance;
use App\Entity\Reservation;
use App\Entity\Salle;
use App\Entity\Utilisateur;


use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        // Affiche une page personnalisée avec le menu latéral EasyAdmin
        return $this->render('admin/dashboard.html.twig');
    }    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Cine Symfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Films', 'fas fa-film', Film::class);
        yield MenuItem::linkToCrud('Séances', 'fas fa-calendar-alt', Seance::class);
        yield MenuItem::linkToCrud('Réservations', 'fas fa-ticket-alt', Reservation::class);
        yield MenuItem::linkToCrud('Salles', 'fas fa-door-open', Salle::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', Utilisateur::class);
    }
}
