<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProvinciaRepository;

class ProvinciaController extends AbstractController
{
    #[Route('/API/provincias', name: 'provincias', methods: ["GET"])]
    public function traeProvincias(ProvinciaRepository $provinciaRepository): JsonResponse
    {
        //Obtiene todas las provincias
        $provincias = $provinciaRepository->findAll();
        
        //Genera un array
        $provinciaArray = [];

        //Bucle que añade datos al array según los datos
        foreach ($provincias as $provincia) 
        {
            //Array de Json
            $provinciaArray[] = $provincia->jsonSerialize();
        }

        //Devuelve el array en JSON
        return new JsonResponse($provinciaArray);
    }
}
