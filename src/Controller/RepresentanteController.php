<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Response, Request};
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\{RepresentanteRepository};
use App\Entity\Representante;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RepresentanteController extends AbstractController
{
    #[Route('/API/representantes', name: "mostrarRepresentantes", methods: ['GET'])]
    public function verRepresentantes(RepresentanteRepository $representanteRepository): JsonResponse
    {
        $personas = $representanteRepository->findAll();

        $personasArray = [];
        foreach($personas as $persona) 
        {
            $personasArray[] = $persona->jsonSerialize();
        }

        return new JsonResponse($personasArray);
    }

    #[Route('/API/crearRepresentante', name: "crearRepresentante", methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $manager, RepresentanteController $controlador): JsonResponse
    {
        //Obtiene el json enviado
        $data = json_decode($request->getContent(), true);
        
        //Distingue cada atributo del json
        $dni = $data['dni'];
        $nombre = $data['nombre'];
        $apellido1 = $data['apellido1'];
        $apellido2 = $data['apellido2'];
        $cargo = $data['cargo'];

        //Si los valores están vacíos
        if(empty($dni) || empty($nombre) || empty($apellido1) || empty($cargo))
        {
            //Lanza una excepción
            throw new NotFoundHttpException('No puede haber valores vacíos.');
        }
        else if(!$controlador->validarDNI($dni))
        {
            //Lanza una excepción
            throw new NotFoundHttpException('Introduce un DNI válido.');
        }

        //Crea el objeto Representante
        $nuevoRepresentante = new Representante();

        //Le añade sus propiedades
        $nuevoRepresentante
            ->setDni($dni)
            ->setNombre($nombre)
            ->setApellido1($apellido2)
            ->setApellido2($apellido2)
            ->setCargo($cargo);

        //Llama a la bdd
        $manager->persist($nuevoRepresentante);

        //Actualiza la bdd
        $manager->flush();

        //Devuelve un json
        return new JsonResponse(['idRepresentante' => $nuevoRepresentante->getId()], Response::HTTP_CREATED);
    }

    #[Route('/API/borrarRepresentante/{id}', name: "borrarRepresentante", methods: ['GET'])]
    public function borrarRepresentante(Representante $persona, EntityManagerInterface $entityManager): JsonResponse
    {
        //Elimina la ruta
        $entityManager->remove($persona);

        //Actualiza la base de datos
        $entityManager->flush();

        //Devuelve un true
        return new JsonResponse("Representante Borrado");
    }

    /**
     * Método para validar DNI. 
     * Requiere el parámetro $dni para poder hacer la validación
     */
    public function validarDNI($dni)
    {
        //Obtiene la letra del dni
        $letra = substr($dni, -1);

        //Obtiene los numeros del dni
        $numeros = substr($dni, 0, -1);
    
        //Genera una condición realizando los cálculos necesarios para saber si el dni es válido
        if(substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1) == $letra && strlen($letra) == 1 && strlen ($numeros) == 8 )
        {
            //Devuelve true, indicando que el dni es correcto
            return true;
        }

        //Devuelve false, indicando que el dni es incorrecto
        return false;
    }
}
