<?php

namespace App\Controller\Admin;

use App\Entity\TutorLaboral;
use EasyCorp\Bundle\EasyAdminBundle\Config\{Action, Actions, Crud, KeyValueStore};
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\{IdField, TextField};


class TutorLaboralCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TutorLaboral::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_EDIT, Action::DETAIL)
            ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return 
        [
            TextField::new('dni')
                ->setFormTypeOption('constraints', 
                [
                    new Callback([$this, 'validarDNI'])
                ])
                ->setRequired(true),
            TextField::new('nombre'),
            TextField::new('apellido1'),
            TextField::new('apellido2'),
        ];
    }

    //Método para validar el DNI 
    public function validarDNI(string $dni, ExecutionContextInterface $context): void
    {
        //Indica el patrón
        $patron = '/^\d{8}[A-Z]$/';

        //Si el patrón no coincide
        if (!preg_match($patron, $dni)) 
        {
            //Crea una violación, que es un mensaje de error de EasyAdmin
            $context->buildViolation('El formato del DNI no es válido.')
                ->addViolation(); //La añade al framework
            
            //Devuelve la respuesta ya que la violación ha sido añadida
            return;
        }

        //Obtiene el número del dni de la cadena
        $numero = substr($dni, 0, 8);

        //Obtiene la letra del dni de la cadena
        $letra = strtoupper(substr($dni, 8, 1));

        //Calcula la letra que debería de ser
        $letraCalculada = $this->calcularLetraDNI($numero);

        //Comprueba que las letras no coincidan
        if ($letraCalculada !== $letra) 
        {
            //Crea una violación, que es un mensaje de error de Symfony
            $context->buildViolation('Introduzca un DNI válido.')
                ->addViolation(); //Añade la violación al framework
        }
    }

    //Método que calcula la letra de un DNI
    private function calcularLetraDNI($numero): string
    {
        //Obtiene todas las letras posibles
        $letras = 'TRWAGMYFPDXBNJZSQVHLCKE';

        //Genera el indice, que es la letra que debería tener ese dni
        $indice = $numero % 23;

        //Devuelve dicha letra
        return $letras[$indice];
    }
    
}
