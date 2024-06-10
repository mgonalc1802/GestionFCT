<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\{UserRepository, TutorLaboralRepository, CentroTrabajoRepository, ActividadFormativoProductivaRepository, ProgramaFormativoRepository, EmpresaRepository};
use Symfony\Component\HttpFoundation\{Response, Request};
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
    public function generarPdf(Request $request, UserRepository $userRepository, TutorLaboralRepository $tutorLaboralRepository, CentroTrabajoRepository $centroTrabajoRepository,
    ProgramaFormativoRepository $programaFormativoRepository, ActividadFormativoProductivaRepository $actividadesRepository, EmpresaRepository $empresaRepository, 
    Pdf $knpSnappyPdf): Response
    {
        //Obtiene el json enviado
        $data = json_decode($request->getContent(), true);

        // Verifica si los campos necesarios están presentes en el JSON
        if (!isset($data['idAlumno'], $data['idTutorLaboral'], $data['idEmpresa'], $data['idCentroTrabajo'], $data['fechaInicio'], $data['fechaFin'])) {
            // Manejar el caso en que falta algún campo
            return new Response('Faltan campos en los datos JSON', 400);
        }

        //Distingue cada atributo del json
        $idAlumno = $data['idAlumno'];
        $idTutorLaboral = $data['idTutorLaboral'];
        $idEmpresa = $data['idEmpresa'];
        $idCentroTrabajo = $data['idCentroTrabajo'];
        $fechaInicio = $data['fechaInicio'];
        $fechaFin = $data['fechaFin'];
        $profesorResponable = $this->getUser();
        
        //Busca todos los alumnos
        $alumno = $userRepository->findById($idAlumno);

        //Busca todos los tutores laborales
        $tutorLaboral = $tutorLaboralRepository->findById($idTutorLaboral);

        //Busca todas las empresas
        $centroTrabajo = $centroTrabajoRepository->findById($idCentroTrabajo);  

        //Obtiene todas las Empresas
        $empresa = $empresaRepository->findById($idEmpresa);

        //Busca todos los resultadosAprendizaje
        $resultadosAprendizaje = $programaFormativoRepository->findAll();

        //Obtiene la hora local para poder indicar el mes en español
        setlocale(LC_TIME, 'es_ES.UTF-8');

        //Obtiene la fecha actual
        $fechaActual = new \DateTime();

        //Obtiene el día, mes y año de la fecha actual
        $dia = $fechaActual->format('d');
        $mes = strftime('%B', $fechaActual->getTimestamp()); // Nombre del mes en español
        $anio = $fechaActual->format('Y');

        $html = $this->renderView('pdf.html.twig', [
            'alumno' => $alumno,
            'tutorLaboral' => $tutorLaboral,
            'empresa' => $empresa,
            'centroTrabajo' => $centroTrabajo,
            'resultadosAprendizaje' => $resultadosAprendizaje,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'profesorResponsable' => $profesorResponable,
            'dia' => $dia,
            'mes' => $mes,
            'anio' => $anio,
        ]);

        //Indica el nombre del archivo
        $nombreArchivo = $alumno->getNombre() . ' ' . $alumno->getApellido1() . ' ' . $alumno->getApellido2() . '.pdf';

         // Ruta donde se guardará el archivo PDF por defecto (carpeta Descargas del usuario)
        $outputPathDefault = 'C:/Users/maria/Downloads/' . $nombreArchivo;

        // Generar el PDF y guardarlo en la ruta por defecto
        $knpSnappyPdf->generateFromHtml($html, $outputPathDefault);

        // Indica la ruta de la carpeta pública donde se almacenarán los archivos descargados
        $outputPathPublic = $this->getParameter('kernel.project_dir') . '/public/pdf/';

        // Ruta donde se guardará el archivo PDF en la carpeta pública
        $outputPathPublic .= $nombreArchivo;

        //Eliminar el archivo existente en la carpeta pública si existe
        if (file_exists($outputPathPublic)) {
            unlink($outputPathPublic);
            unlink($outputPathDefault);
        }

        // Copiar el archivo PDF a la carpeta pública
        copy($outputPathDefault, $outputPathPublic);

        // Crear una respuesta de descarga
        return $this->file($outputPathDefault, $nombreArchivo, ResponseHeaderBag::DISPOSITION_ATTACHMENT);
    }
}
