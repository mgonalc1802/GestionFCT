<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\{UserRepository, TutorLaboralRepository, CentroTrabajoRepository, ActividadFormativoProductivaRepository, ProgramaFormativoRepository, EmpresaRepository};
use Symfony\Component\HttpFoundation\{Response};
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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
        // return $this->render('pdf.html.twig', [
            'alumnos' => $alumnos,
            'tutoresLaborales' => $tutoresLaborales,
            'centrosTrabajo' => $centrosTrabajo,
            'empresas' => $empresas,
            'resultadosAprendizaje' => $resultadosAprendizaje,
        ]);
    }

    #[Route('/API/generarPdf', name: 'generarPDF', methods: ['POST'] )]
    public function generarPdf(UserRepository $userRepository, TutorLaboralRepository $tutorLaboralRepository, CentroTrabajoRepository $centroTrabajoRepository,
    ProgramaFormativoRepository $programaFormativoRepository, ActividadFormativoProductivaRepository $actividadesRepository, EmpresaRepository $empresaRepository, Pdf $knpSnappyPdf): Response
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

        //Obtiene la fecha inicio
        $fechaInicio = "22 de Marzo";

        //Obtiene la fecha de fin
        $fechaFin = "17 de Julio";

        //Obtiene la hora local para poder indicar el mes en español
        setlocale(LC_TIME, 'es_ES.UTF-8');

        //Obtiene la fecha actual
        $fechaActual = new \DateTime();

        //Obtiene el día, mes y año de la fecha actual
        $dia = $fechaActual->format('d');
        $mes = strftime('%B', $fechaActual->getTimestamp()); // Nombre del mes en español
        $anio = $fechaActual->format('Y');

        $html = $this->renderView('pdf.html.twig', [
            'alumno' => $alumnos[0],
            'tutorLaboral' => $tutoresLaborales[0],
            'centroTrabajo' => $centrosTrabajo[0],
            'empresa' => $empresas[0],
            'resultadosAprendizaje' => $resultadosAprendizaje,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'dia' => $dia,
            'mes' => $mes,
            'anio' => $anio,
        ]);


        // return $this->render('pdf.html.twig', [
        //     'alumno' => $alumnos[0],
        //     'tutorLaboral' => $tutoresLaborales[0],
        //     'centroTrabajo' => $centrosTrabajo[0],
        //     'empresa' => $empresas[0],
        //     'resultadosAprendizaje' => $resultadosAprendizaje,
        //     'fechaInicio' => $fechaInicio,
        //     'fechaFin' => $fechaFin,
        //     'dia' => $dia,
        //     'mes' => $mes,
        //     'anio' => $anio,
        // ]);

        //Indica el nombre del archivo
        $nombreArchivo = $alumnos[0]->getNombre() . ' ' . $alumnos[0]->getApellido1() . ' ' . $alumnos[0]->getApellido2() . '.pdf';

        // Ruta donde se guardará el archivo PDF
        $outputPath = $this->getParameter('kernel.project_dir') . '/public/pdf/' . $nombreArchivo;

        // Generar el PDF y guardarlo en la ruta especificada
        $knpSnappyPdf->generateFromHtml($html, $outputPath);

        // Crear una respuesta de descarga
        return $this->file($outputPath, $nombreArchivo, ResponseHeaderBag::DISPOSITION_ATTACHMENT);
    }
}
