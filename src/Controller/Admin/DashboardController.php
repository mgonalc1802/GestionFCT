<?php

namespace App\Controller\Admin;

use App\Entity\{User, TutorLaboral, Empresa, Provincia, Localidad, CursoEscolar, FamiliaProfesional, CicloFormativo};
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

    #[Route('/admin/centros', name: 'centros')]
    public function centros(): Response
    {
        return $this->render('centro_trabajo/index.html.twig');
    }

    #[Route('/admin/verCentros', name: 'verCentros')]
    public function verCentros(): Response
    {
        return $this->render('centro_trabajo/show.html.twig');
    }

    #[Route('/admin/representantes', name: 'representantes')]
    public function representantes(): Response
    {
        return $this->render('representante/index.html.twig');
    }

    #[Route('/admin/verRepresentantes', name: 'verRepresentantes')]
    public function verRepresentantes(): Response
    {
        return $this->render('representante/show.html.twig');
    }

    #[Route('/admin/personasContacto', name: 'personasContacto')]
    public function personasContacto(): Response
    {
        return $this->render('persona_contacto/index.html.twig');
    }

    #[Route('/admin/verPersonasContacto', name: 'verPersonasContacto')]
    public function verPersonasContacto(): Response
    {
        return $this->render('persona_contacto/show.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('GestionFCT');
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    // public function configureAssets(): Assets
    // {
    //     return parent::configureAssets()
    //         ->addCssFile("css/estilo/easyAdmin/admin.css");
    // }

    public function configureMenuItems(): iterable
    {
        //Dirigir a la Web
        yield MenuItem::linkToUrl('Vuelta a la Web', 'fa fa-home', '/');

        //Crea la sección personas
        yield MenuItem::section('Personas');
        //CRUD de usuarios
        yield MenuItem::linkToCrud('Usuarios', 'fa fa-users', User::class); 

        //CRUD de tutores laborales
        yield MenuItem::linkToCrud('Tutores Laborables', 'fa fa-building-user', TutorLaboral::class);

        //CRUD de representantes
        yield MenuItem::linkToRoute('Representantes', 'fa fa-user-tie', "verRepresentantes");

        //CRUD de personas de contacto
        yield MenuItem::linkToRoute('Personas de Contacto', 'fa fa-circle-user   ', "verPersonasContacto");


        //Crea la sección Empresariales
        yield MenuItem::section('Empresariales');

        //CRUD de familiaProfesional
        yield MenuItem::linkToCrud('Familia Profesional', 'fa fa-wrench', FamiliaProfesional::class);

        //CRUD de Empresas
        yield MenuItem::linkToCrud('Empresas', 'fa fa-briefcase', Empresa::class);

        //CRUD de centros de trabajo
        yield MenuItem::linkToRoute('Centros de Trabajo', 'fa fa-building', "verCentros");

        //Crea la sección localización
        yield MenuItem::section('Localización');

        //CRUD de Provincia
        yield MenuItem::linkToCrud('Provincia', 'fa fa-map-marker', Provincia::class);

        //CRUD de Localidad
        yield MenuItem::linkToCrud('Localidad', 'fa fa-map-pin', Localidad::class);

        //Crea la sección localización
        yield MenuItem::section('Instituto');

        //CRUD de CursoEscolar
        yield MenuItem::linkToCrud('Curso Escolar', 'fa fa-school', CursoEscolar::class);

        //CRUD de CicloFormativo
        yield MenuItem::linkToCrud('Ciclo Formativo', 'fa fa-graduation-cap', CicloFormativo::class);
    }
}
