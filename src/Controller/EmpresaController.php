<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Response};
use App\Repository\{EmpresaRepository, UserRepository, RepresentanteRepository, TutorLaboralRepository, CursoEscolarRepository};
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\{Empresa};
class EmpresaController extends AbstractController
{
    #[Route('/datosEmpresa', name: 'datosEmpresa')]
    public function datosEmpresa(EmpresaRepository $empresaRepository, UserRepository $userRepository, RepresentanteRepository $representanteRepository,
    TutorLaboralRepository $tutorLaboralRepository, CursoEscolarRepository $cursoEscolarRepository): Response
    {
        //Obtiene todas las Empresas
        $empresas = $empresaRepository->findAll();  
        
        //Obtiene todos los alumnos
        $alumnos = $userRepository->findAlumnos();

        //Obtiene todos los representantes
        $representantes = $representanteRepository->findAll();

        //Obtiene todos los tutores laborales
        $tutoresLaborales = $tutorLaboralRepository->findAll();

        //Obtiene todos los profesores
        $profesores = $userRepository->findProfesores();

        //Obtiene el curso escolar
        $cursosEscolares = $cursoEscolarRepository->findAll();

        return $this->render('empresa/index.html.twig', [
            'empresas' => $empresas,
            'alumnos' => $alumnos,
            'representantes' => $representantes,
            'tutoresLaborales' => $tutoresLaborales,
            'profesores' => $profesores,
            'cursosEscolares' => $cursosEscolares,
        ]);
    }

    #[Route('/API/centrosEmpresa/{id}', name: 'mostrarCentrosEmpresa', methods: ['GET'])]
    public function verEmpresas(Empresa $empresa, EmpresaRepository $empresaRepository): JsonResponse
    {
        //Obtiene todas las Empresas
        $centros = $empresa->serializeCollection($empresa->getCentros());

        //Devuelve una respuesta JSON con los datos
        return new JsonResponse($centros);
    }
}
