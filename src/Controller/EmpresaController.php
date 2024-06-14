<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request, JsonResponse};
use App\Repository\{UserRepository, TutorLaboralRepository, CentroTrabajoRepository, RepresentanteRepository, EmpresaRepository, CursoEscolarRepository, PersonaContactoRepository};
use Symfony\Component\Routing\Attribute\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\{Empresa};
class EmpresaController extends AbstractController
{
    #[Route('/datosEmpresa', name: 'datosEmpresa')]
    public function datosEmpresa(EmpresaRepository $empresaRepository, UserRepository $userRepository, PersonaContactoRepository $personaContactoRepository,
    TutorLaboralRepository $tutorLaboralRepository, CursoEscolarRepository $cursoEscolarRepository, Pdf $knpSnappyPdf): Response
    {
        //Obtiene todas las Empresas
        $empresas = $empresaRepository->findAll();  
        
        //Obtiene todos los alumnos
        $alumnos = $userRepository->findAlumnos();

        //Obtiene todos los representantes
        $personasContacto = $personaContactoRepository->findAll();

        //Obtiene todos los tutores laborales
        $tutoresLaborales = $tutorLaboralRepository->findAll();

        //Obtiene todos los profesores
        $profesores = $userRepository->findProfesores();

        //Obtiene el curso escolar
        $cursosEscolares = $cursoEscolarRepository->findAll();

        return $this->render('empresa/index.html.twig', [
            'empresas' => $empresas,
            'alumnos' => $alumnos,
            'personasContacto' => $personasContacto,
            'tutoresLaborales' => $tutoresLaborales,
            'profesores' => $profesores,
            'cursosEscolares' => $cursosEscolares,
        ]);
    }

    #[Route('/API/generarHojaEmpresa', name: 'generarHojaEmpresa' /*, methods: ['POST']*/)]
    public function generarHojaEmpresa(Request $request, UserRepository $userRepository, TutorLaboralRepository $tutorLaboralRepository, CentroTrabajoRepository $centroTrabajoRepository,
    EmpresaRepository $empresaRepository, CursoEscolarRepository $cursoEscolarRepository, PersonaContactoRepository $personaContactoRepository, Pdf $knpSnappyPdf, EntityManagerInterface $manager): JsonResponse
    {
        //Obtiene el json enviado
        $data = json_decode($request->getContent(), true);

        // Verifica si los campos necesarios están presentes en el JSON
        if (!isset($data['idAlumno'], $data['idTutorLaboral'], $data['idEmpresa'], $data['idCentroTrabajo'], $data['fechaInicio'], $data['idProfesor'],  $data['idPersonaContacto'],  $data['idCurso'])) {
            //Manejar el caso en que falta algún campo
            return new JsonResponse('Faltan campos en los datos JSON', 400);
        }

        if($data['lunes'] > 8 || $data['lunes'] < 0){
            //Manejar el caso en que no se cumpla la condición
            return new JsonResponse('Las horas no pueden ser negativas ni mayores de 8.', 400);
        }

        //Distingue cada atributo del json
        $idAlumno = $data['idAlumno'];
        $idTutorLaboral = $data['idTutorLaboral'];
        $idEmpresa = $data['idEmpresa'];
        $idCentroTrabajo = $data['idCentroTrabajo'];
        $fechaInicio = $data['fechaInicio'];
        $idProfesor = $data['idProfesor'];
        $idPersonaContacto = $data['idPersonaContacto'];
        $idCursoEscolar = $data['idCurso'];
        $lunes = $data['lunes'];
        $martes = $data['martes'];
        $miercoles = $data['miercoles'];
        $jueves = $data['jueves'];
        $viernes = $data['viernes'];

        //Obtiene la fecha actual
        $fechaActual = new \DateTime();

        //Formatea la fecha como cadena
        $fechaFormateada = $fechaActual->format('d/m/Y');

        // $idAlumno = 9;
        // $idTutorLaboral = 1;
        // $idEmpresa = 1;
        // $idCentroTrabajo = 1;
        // $fechaInicio = "22 de Julio de 2024";
        // $idProfesor = 3;
        // $idPersonaContacto = 1;
        // $idCursoEscolar = 1;
        // $lunes = 8;
        // $martes = 8;
        // $miercoles = 8;
        // $jueves = 8;
        // $viernes = 8;
        
        //Busca el los alumno
        $alumno = $userRepository->findById($idAlumno);

        //Busca el tutor laboral
        $tutorLaboral = $tutorLaboralRepository->findById($idTutorLaboral);

        //Busca el centro de trabajo
        $centroTrabajo = $centroTrabajoRepository->findById($idCentroTrabajo);  

        //Obtiene la empresa
        $empresa = $empresaRepository->findById($idEmpresa);

        //Busca el profesor
        $profesor = $userRepository->findById($idProfesor);

        //Busca la persona de contacto
        $personaContacto = $personaContactoRepository->findById($idPersonaContacto);

        //Busca el curso escolar
        $cursoEscolar = $cursoEscolarRepository->findById($idCursoEscolar);

        $html = $this->renderView('empresa/pdf.html.twig', [
            'alumno' => $alumno,
            'tutorLaboral' => $tutorLaboral,
            'empresa' => $empresa,
            'centroTrabajo' => $centroTrabajo,
            'personaContacto' => $personaContacto,
            'fechaInicio' => $fechaInicio,
            'fechaActual' => $fechaFormateada,
            'profesor' => $profesor,
            'cursoEscolar'=>$cursoEscolar,
            'lunes' => $lunes,
            'martes' => $martes,
            'miercoles' => $miercoles,
            'jueves' => $jueves,
            'viernes' => $viernes
        ]);

        //Indica el nombre del archivo
        $nombreArchivo = $empresa->getNombre() . '-' . $alumno->getNombre() . $alumno->getApellido1() . '.pdf';

        //Ruta donde se guardará el archivo PDF por defecto (carpeta Descargas del usuario)
        $outputPathDefault = 'C:/Users/maria/Downloads/' . $nombreArchivo;

        //Generar el PDF y guardarlo en la ruta por defecto
        $knpSnappyPdf->generateFromHtml($html, $outputPathDefault);

        //Indica la ruta de la carpeta pública donde se almacenarán los archivos descargados
        $outputPathPublic = $this->getParameter('kernel.project_dir') . '/public/pdf/datosEmpresa/';

        //Ruta donde se guardará el archivo PDF en la carpeta pública
        $outputPathPublic .= $nombreArchivo;

        //Copia el archivo PDF a la carpeta pública
        copy($outputPathDefault, $outputPathPublic);

        return new JsonResponse(['PDF generado correctamente.'], Response::HTTP_CREATED);
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
