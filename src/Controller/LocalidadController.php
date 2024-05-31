<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\LocalidadRepository;


class LocalidadController extends AbstractController
{
    #[Route('/API/localidades', name: 'localidades', methods: ["GET"])]
    public function traeLocalidades(LocalidadRepository $localidadRepository): JsonResponse
    {
        //Obtiene todas las localidades
        $localidades = $localidadRepository->findAll();
        
        //Genera un array
        $localidadArray = [];

        //Bucle que añade datos al array según los datos
        foreach ($localidades as $localidad) 
        {
            //Array de Json
            $localidadArray[] = $localidad->jsonSerialize();
        }

        //Devuelve el array en JSON
        return new JsonResponse($localidadArray);
    }

    #[Route('/API/localidades/{provincia}', name: 'localidadesProv', methods: ["GET"])]
    public function traeLocalidadesPorProvincia(LocalidadRepository $localidadRepository, $provincia): JsonResponse
    {
        //Obtiene todas las localidades
        $localidades = $localidadRepository->findByProvincia($provincia);
        
        //Genera un array
        $localidadArray = [];

        //Bucle que añade datos al array según los datos
        foreach ($localidades as $localidad) 
        {
            //Array de Json
            $localidadArray[] = $localidad->jsonSerialize();
        }

        //Devuelve el array en JSON
        return new JsonResponse($localidadArray);
    }
}
