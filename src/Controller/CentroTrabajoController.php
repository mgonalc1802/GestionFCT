<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Response, Request};
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\{LocalidadRepository, CentroTrabajoRepository};
use App\Entity\CentroTrabajo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class CentroTrabajoController extends AbstractController
{
    #[Route('/API/centros', name: "mostrarCentros", methods: ['GET'])]
    public function verCentos(CentroTrabajoRepository $centroTrabajoRepository): JsonResponse
    {
        $centros = $centroTrabajoRepository->findAll();

        $centrosArray = [];
        foreach($centros as $centro) 
        {
            $centrosArray[] = $centro->jsonSerialize();
        }

        return new JsonResponse($centrosArray);
    }

    #[Route('/API/modificarCentro', name: "modifica", methods: ['POST'])]
    public function update(Request $request, EntityManagerInterface $manager, CentroTrabajoRepository $centroTrabajoRepository): JsonResponse
    {
        //Obtiene el json enviado
        $data = json_decode($request->getContent(), true);
        
        //Distingue cada atributo del json
        $id = $data['id'];
        $email = $data['email'];
        $telefono = $data['telefono'];
        $direccion = $data['direccion'];
        $fax = $data['fax'];

        //Si están vacíos
        if(empty($email) || empty($telefono) || empty($direccion))
        {
            //Lanza una json indicando el error
            throw new JsonResponse('No puede haber valores vacíos.', 400);
        }

        $centroTrabajo = $centroTrabajoRepository->findById($id);

        //Le añade sus propiedades
        $centroTrabajo
            ->setEmail($email)
            ->setTelefono($telefono)
            ->setDireccion($direccion)
            ->setFax($fax);

        //Llama a la bdd
        $manager->persist($centroTrabajo);

        //Actualiza la bdd
        $manager->flush();

        //Devuelve un json
        return new JsonResponse(['PCentro de Trabajo Actualizado. ID: ' => $centroTrabajo->getId()], Response::HTTP_CREATED);
    }

    #[Route('/API/crearCentro', name: "crearCentro", methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $manager, LocalidadRepository $localidadRepository): JsonResponse
    {
        //Obtiene el json enviado
        $data = json_decode($request->getContent(), true);
        
        //Distingue cada atributo del json
        $email = $data['email'];
        $telefono = $data['telefono'];
        $direccion = $data['direccion'];
        $fax = $data['fax'];
        $nombreLocalidad = $data['localidad'];

        //Si los valores están vacíos
        if(empty($telefono) || empty($direccion) || empty($nombreLocalidad))
        {
            //Lanza una excepción
            throw new NotFoundHttpException('No puede haber valores vacíos.'. $fax);
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) //Método para validar emails
        {
            //Lanza una excepción
            throw new NotFoundHttpException('Introduzca un email válido.');
        }

        $localidad = $localidadRepository->findByNombre($nombreLocalidad);

        //Crea el objeto CentroTrabajo
        $nuevoCentro = new CentroTrabajo();
        
        if(empty($fax))
        {
            //Le añade sus propiedades
            $nuevoCentro
            ->setEmail($email)
            ->setTelefono($telefono)
            ->setDireccion($direccion)
            ->setLocalid($localidad);
        }
        else
        {
            //Le añade sus propiedades
            $nuevoCentro
                ->setEmail($email)
                ->setTelefono($telefono)
                ->setDireccion($direccion)
                ->setFax($fax)
                ->setLocalid($localidad);
        }


        
        //Llama a la bdd
        $manager->persist($nuevoCentro);

        //Actualiza la bdd
        $manager->flush();

        //Devuelve un json
        return new JsonResponse(['idCentro' => $nuevoCentro->getId()], Response::HTTP_CREATED);
    }

    #[Route('/API/borrarCentro/{id}', name: "centro", methods: ['GET'])]
    public function borrarCentro(CentroTrabajo $centro, EntityManagerInterface $entityManager): JsonResponse
    {
        //Elimina la ruta
        $entityManager->remove($centro);

        //Actualiza la base de datos
        $entityManager->flush();

        //Devuelve un true
        return new JsonResponse("Centro de Trabajo Borrado");
    }
}
