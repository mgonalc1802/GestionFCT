<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Response, Request};
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\{PersonaContactoRepository};
use App\Entity\PersonaContacto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PersonaContactoController extends AbstractController
{
    #[Route('/API/personasContacto', name: "mostrarPersonasContacto", methods: ['GET'])]
    public function verPersonasContacto(PersonaContactoRepository $personaContactoRepository): JsonResponse
    {
        $personas = $personaContactoRepository->findAll();

        $personasArray = [];
        foreach($personas as $persona) 
        {
            $personasArray[] = $persona->jsonSerialize();
        }

        return new JsonResponse($personasArray);
    }

    #[Route('/API/crearPersonaContacto', name: "crearPersonaContacto", methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $manager): JsonResponse
    {
        //Obtiene el json enviado
        $data = json_decode($request->getContent(), true);
        
        //Distingue cada atributo del json
        $nombre = $data['nombre'];
        $apellido1 = $data['apellido1'];
        $apellido2 = $data['apellido2'];
        $telefono = $data['telefono'];

        //Si los valores están vacíos
        if(empty($telefono) || empty($nombre) || empty($apellido1))
        {
            //Lanza una excepción
            throw new NotFoundHttpException('No puede haber valores vacíos.');
        }

        //Crea el objeto PersonaContacto
        $nuevoPersonaContacto = new PersonaContacto();

        //Le añade sus propiedades
        $nuevoPersonaContacto
            ->setNombre($nombre)
            ->setApellido1($apellido1)
            ->setApellido2($apellido2)
            ->setTelefono($telefono);

        //Llama a la bdd
        $manager->persist($nuevoPersonaContacto);

        //Actualiza la bdd
        $manager->flush();

        //Devuelve un json
        return new JsonResponse(['idPersonaContacto' => $nuevoPersonaContacto->getId()], Response::HTTP_CREATED);
    }

    #[Route('/API/borrarPersonaContacto/{id}', name: "borrarPersonaContacto", methods: ['GET'])]
    public function borrarPersonaContacto(PersonaContacto $persona, EntityManagerInterface $entityManager): JsonResponse
    {
        //Elimina la ruta
        $entityManager->remove($persona);

        //Actualiza la base de datos
        $entityManager->flush();

        //Devuelve un true
        return new JsonResponse("Persona de Contacto Borrado");
    }

    #[Route('/API/modificarPersonaContacto', name: "modificar", methods: ['POST'])]
    public function update(Request $request, EntityManagerInterface $manager, PersonaContactoRepository $personaContactoRepository): JsonResponse
    {
        //Obtiene el json enviado
        $data = json_decode($request->getContent(), true);
        
        //Distingue cada atributo del json
        $id = $data['id'];
        $nombre = $data['nombre'];
        $apellido1 = $data['apellido1'];
        $apellido2 = $data['apellido2'];
        $telefono = $data['telefono'];

        //Si están vacíos
        if(empty($nombre) || empty($apellido1) || empty($telefono))
        {
            //Lanza una json indicando el error
            throw new JsonResponse('No puede haber valores vacíos.', 400);
        }

        $personaActualizada = $personaContactoRepository->findById($id);

        //Le añade sus propiedades
        $personaActualizada
            ->setNombre($nombre)
            ->setApellido1($apellido1)
            ->setApellido2($apellido2)
            ->setTelefono($telefono);

        //Llama a la bdd
        $manager->persist($personaActualizada);

        //Actualiza la bdd
        $manager->flush();

        //Devuelve un json
        return new JsonResponse(['Persona Contacto Actualizada. ID: ' => $personaActualizada->getId()], Response::HTTP_CREATED);
    }
}
