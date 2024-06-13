<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\{UserRepository, TutorLaboralRepository, CentroTrabajoRepository, ActividadFormativoProductivaRepository, ProgramaFormativoRepository, 
                    EmpresaRepository, ConvenioRepository, CursoEscolarRepository};
use App\Entity\{Convenio, Periodo};
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\{Response, Request, JsonResponse};
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Snappy\Pdf;
use DateTime;
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
    ConvenioRepository $convenioRepository, CursoEscolarRepository $cursoEscolarRepository, Pdf $knpSnappyPdf, EntityManagerInterface $manager): JsonResponse
    {
        //Obtiene el json enviado
        $data = json_decode($request->getContent(), true);

        // Verifica si los campos necesarios están presentes en el JSON
        if (!isset($data['idAlumno'], $data['idTutorLaboral'], $data['idEmpresa'], $data['idCentroTrabajo'], $data['fechaInicio'], $data['fechaFin'])) {
            // Manejar el caso en que falta algún campo
            return new JsonResponse('Faltan campos en los datos JSON', 400);
        }

        //Distingue cada atributo del json
        $idAlumno = $data['idAlumno'];
        $idTutorLaboral = $data['idTutorLaboral'];
        $idEmpresa = $data['idEmpresa'];
        $idCentroTrabajo = $data['idCentroTrabajo'];
        $fechaInicio = $data['fechaInicio'];
        $fechaFin = $data['fechaFin'];
        $profesorResponsable = $this->getUser();
        $idCursoEscolar = $data['idCurso'];
        
        //Busca el los alumno
        $alumno = $userRepository->findById($idAlumno);

        //Busca el tutor laboral
        $tutorLaboral = $tutorLaboralRepository->findById($idTutorLaboral);

        //Busca el centro de trabajo
        $centroTrabajo = $centroTrabajoRepository->findById($idCentroTrabajo);  

        //Obtiene la empresa
        $empresa = $empresaRepository->findById($idEmpresa);

        //Busca todos los resultadosAprendizaje
        $resultadosAprendizaje = $programaFormativoRepository->findAll();

        //Busca el curso escolar
        $cursoEscolar = $cursoEscolarRepository->findById($idCursoEscolar);

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
            'profesorResponsable' => $profesorResponsable,
            'dia' => $dia,
            'mes' => $mes,
            'anio' => $anio,
            'cursoEscolar'=>$cursoEscolar
        ]);

        //Indica el nombre del archivo
        $nombreArchivo = $alumno->getNombre() . $alumno->getApellido1() . $alumno->getApellido2() . '.pdf';

        //Ruta donde se guardará el archivo PDF por defecto (carpeta Descargas del usuario)
        $outputPathDefault = 'C:/Users/maria/Downloads/' . $nombreArchivo;

        //Verifica si el alumno ya tiene un convenio
        $convenios = $convenioRepository->findAll();

        //Crea una variable nula
        $convenioEncontrado = null;

        //Buscar el convenio
        foreach ($convenios as $convenio) {
            //Obtiene la colección de alumnos asociados al convenio
            $alumnos = $convenio->getAlumnos();

            //Verificar si el alumno está asociado a este convenio
            foreach ($alumnos as $alumnoBuscar) {
                if ($alumnoBuscar->getId() === $alumno->getId()) {
                    //Guarda ese convenio
                    $convenioEncontrado = $convenio;
                }
            }
        }

        //Si el convenio no es nulo
        if ($convenioEncontrado == null) { 
            //Definir el formato de la fecha de entrada
            $format = 'd \d\e F \d\e Y';

            //Crea una instancia de DateTime a partir del formato y la fecha de entrada
            $fechaInicioPeriodo = \DateTime::createFromFormat($format, $fechaInicio);
            $fechaFinPeriodo = \DateTime::createFromFormat($format, $fechaFin);

            //Crea y guarda el nuevo periodo
            $periodo = new Periodo();
            $periodo
                ->setFechaInicio(date_create($fechaInicioPeriodo))
                ->setFechaFin(date_create($fechaFinPeriodo))
                ->setCursos($cursoEscolar);

            //Inserta el periodo
            $manager->persist($periodo);
            $manager->flush();

            //Crear y guardar el nuevo objeto Convenio
            $convenio = new Convenio();
            $convenio
                ->setCentroTrab($centroTrabajo)
                ->setTutorLab($tutorLaboral)
                ->addAlumno($alumno)
                ->addUser($profesorResponsable)
                ->setPdf($nombreArchivo);

            //Inserta el convenio
            $manager->persist($convenio);
            $manager->flush();

            //Generar el PDF y guardarlo en la ruta por defecto
            $knpSnappyPdf->generateFromHtml($html, $outputPathDefault);

            //Indica la ruta de la carpeta pública donde se almacenarán los archivos descargados
            $outputPathPublic = $this->getParameter('kernel.project_dir') . '/public/pdf/';

            //Ruta donde se guardará el archivo PDF en la carpeta pública
            $outputPathPublic .= $nombreArchivo;

            //Copia el archivo PDF a la carpeta pública
            copy($outputPathDefault, $outputPathPublic);

            //Devuelve un jsonWW
            return new JsonResponse(['idConvenio' => $convenio->getId()], Response::HTTP_CREATED);
        } 
        else {
            //Lanza una excepción
            return new JsonResponse('El alumno ya tiene un convenio registrado.', Response::HTTP_BAD_REQUEST);
        }
    }
}
