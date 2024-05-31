<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\{UserRepository, TutorLaboralRepository, CentroTrabajoRepository, ActividadFormativoProductivaRepository, ProgramaFormativoRepository, EmpresaRepository};
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProgramaFormativoController extends AbstractController
{
    #[Route('/formularioProgramaFormativo', name: 'formularioProgramaFormativo')]
    public function formularioProgramaFormativo(UserRepository $userRepository, TutorLaboralRepository $tutorLaboralRepository, CentroTrabajoRepository $centroTrabajoRepository,
    ProgramaFormativoRepository $programaFormativoRepository, ActividadFormativoProductivaRepository $actividadesRepository, EmpresaRepository $empresaRepository): Response
    {
        //Busca todos los alumnos
        $alumnos = $userRepository->findAlumnos();

        //Busca todos los tutores laborales
        $tutoresLaborales = $tutorLaboralRepository->findAll();

        //Busca todas las empresas
        $centrosTrabajo = $centroTrabajoRepository->findAll();  

        //Obtiene todas las Empresas
        $empresas = $empresaRepository->findAll();

        //Busca todos los resultadosAprendizaje
        $resultadosAprendizaje = $programaFormativoRepository->findAll();


        return $this->render('programa_formativo/index.html.twig', [
            'alumnos' => $alumnos,
            'tutoresLaborales' => $tutoresLaborales,
            'centrosTrabajo' => $centrosTrabajo,
            'empresas' => $empresas,
            'resultadosAprendizaje' => $resultadosAprendizaje,
        ]);
    }
}
