<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Response};
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CursoEscolarRepository;

class CursoEscolarController extends AbstractController
{
    #[Route('/API/cursosEscolares', name: 'mostrarCursosEscolares', methods: ['GET'])]
    public function verCursos(CursoEscolarRepository $cursoEscolarRepository): JsonResponse
    {
        //Obtiene todas las Empresas
        $cursos = $cursoEscolarRepository->findAll();

        //Genera un array
        $cursoArray = [];

        //Bucle que añade datos al array según los datos
        foreach ($cursos as $curso) 
        {
            //Array de Json
            $cursoArray[] = $curso->jsonSerialize();
        }

        //Devuelve una respuesta JSON con los datos
        return new JsonResponse($cursoArray);
    }
}
