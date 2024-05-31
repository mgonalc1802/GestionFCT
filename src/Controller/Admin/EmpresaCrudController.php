<?php

namespace App\Controller\Admin;

use App\Entity\Empresa;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\{IdField, TextField, EmailField, AssociationField, IntegerField};

class EmpresaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Empresa::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return 
        [
            TextField::new('nif'),
            EmailField::new('email'),
            TextField::new('nombre'),
            TextField::new('actividad'),
            TextField::new('domicilioSocial')
                ->onlyOnForms(),
            TextField::new('telefono'),
            IntegerField::new('fax')
                ->onlyOnForms(),
            TextField::new('tutorDocente')
                ->onlyOnForms(),
            AssociationField::new("familiaProfesional")
                ->setLabel('Familia Profesional'),
            AssociationField::new("localid")
                ->setLabel('Localidad'),
            AssociationField::new("centros")
                ->setLabel('Centros de Trabajo')
                ->onlyOnForms(),
            AssociationField::new("tutorLab")
                ->setLabel('Tutor Laboral')
                ->onlyOnForms(),
            AssociationField::new("repres")
                ->setLabel('Representante'),
            AssociationField::new("personaCont")
                ->setLabel('Persona de Contacto'),
        ];
    }
}
