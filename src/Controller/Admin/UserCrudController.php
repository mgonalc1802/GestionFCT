<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\{Action, Actions, Crud, KeyValueStore};
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\{IdField, EmailField, TextField, ArrayField, AssociationField};
use Symfony\Component\Form\Extension\Core\Type\{PasswordType, RepeatedType};
use Symfony\Component\Form\{FormBuilderInterface, FormEvent, FormEvents};
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class UserCrudController extends AbstractCrudController
{
    public function __construct
    (
        public UserPasswordHasherInterface $userPasswordHasher
    )
    {

    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_EDIT, Action::DETAIL)
            ;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return 
        [
            EmailField::new('email'),
            TextField::new('dni')
                ->setFormTypeOption('constraints', 
                [
                    new Callback([$this, 'validarDNI'])
                ])
                ->setRequired(true),
            TextField::new('nombre'),
            TextField::new('apellido1'),
            TextField::new('apellido2'),
            TextField::new('password')
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->onlyOnForms()
                ->setFormType(RepeatedType::class)
                ->setFormTypeOptions(
                    [
                        'type' => PasswordType::class,
                        'first_options' => ['label' => 'Contraseña'],
                        'second_options' => ['label' => 'Repetir Contraseña'],
                        'mapped' => false,
                    ]
                ),ArrayField::new("roles"),
            AssociationField::new('cicloFormativo')
                ->setLabel('Ciclo Formativo')
            
        ];
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
        return $this->addPasswordEventListener($formBuilder);
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
        return $this->addPasswordEventListener($formBuilder);
    }

    private function addPasswordEventListener(FormBuilderInterface $formBuilder): FormBuilderInterface
    {
        return $formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->hashPassword());
    }

    private function hashPassword() 
    {
        return function($event) 
        {
            $form = $event->getForm();

            if (!$form->isValid()) 
            {
                return;
            }

            $password = $form->get('password')->getData();

            if ($password === null) 
            {
                return;
            }

            $hash = $this->userPasswordHasher->hashPassword($this->getUser(), $password);
            $form->getData()->setPassword($hash);
        };
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