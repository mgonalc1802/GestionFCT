<?php

namespace App\Controller\Admin;

use App\Entity\{User, TutorLaboral};
use EasyCorp\Bundle\EasyAdminBundle\Config\{Dashboard, Action, Actions, Crud, Assets, MenuItem};
use EasyCorp\Bundle\EasyAdminBundle\Controller\{AbstractDashboardController, AbstractCrudController};
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('GestionFCT');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Front', 'fa fa-home', '/');
        yield MenuItem::linkToCrud('Usuarios', 'fa fa-users', User::class);
        yield MenuItem::linkToCrud('Tutores Laborables', 'fa fa-users', TutorLaboral::class);

        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
