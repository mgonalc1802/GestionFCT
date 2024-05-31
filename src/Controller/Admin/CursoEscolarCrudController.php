<?php

namespace App\Controller\Admin;

use App\Entity\CursoEscolar;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class CursoEscolarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CursoEscolar::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('anioInicio'),
            IntegerField::new('anioFin'),
        ];
    }
}
