<?php
    namespace App\Controller;

    use Symfony\Component\HttpFoundation\{Response, Request, JsonResponse};
    use Symfony\Component\Routing\Annotation\Route;
    use App\Repository\{EmpresaRepository, UserRepository, ConvenioRepository};
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Finder\Finder;


    //Metalenguaje que ejecuta nuestros ficheros buscando los atributos necesarios      
    class ArchivoController extends AbstractController
    {
        #[Route('/datosGenerales', name: 'datosGenerales')] 
        public function datosGenerales(EmpresaRepository $empresaRepository, UserRepository $userRepository): Response
        {
            //Obtiene la ruta donde se encuentral los pdf's
            $pdfDirectory = $this->getParameter('pdf_directory');

            //Utiliza Finder para buscar archivos PDF en el directorio
            $finder = new Finder();
            $finder->files()->in($pdfDirectory)->name('*.pdf');
    
            //Genera un array vacío
            $pdfFiles = [];

            //Obtiene la lista de archivos
            foreach ($finder as $file) {
                $pdfFiles[] = $file->getFilename();
            }

            //Obtiene la ruta donde se encuentral los pdf's
            $pdfDirectoryAlumnos = $this->getParameter('pdf_directory2');

            //Utiliza Finder para buscar archivos PDF en el directorio
            $finderAlumnos = new Finder();
            $finderAlumnos->files()->in($pdfDirectoryAlumnos)->name('*.pdf');
    
            //Genera un array vacío
            $pdfFilesAlumnos = [];

            //Obtiene la lista de archivos
            foreach ($finderAlumnos as $file) {
                $pdfFilesAlumnos[] = $file->getFilename();
            }

            //Obtiene la ruta donde se encuentral los pdf's
            $pdfDirectoryEncuesta = $this->getParameter('pdf_directory3');

            //Utiliza Finder para buscar archivos PDF en el directorio
            $finderEncuesta = new Finder();
            $finderEncuesta->files()->in($pdfDirectoryEncuesta)->name('*.pdf');
    
            //Genera un array vacío
            $pdfFilesEncuestas = [];

            //Obtiene la lista de archivos
            foreach ($finderEncuesta as $file) {
                $pdfFilesEncuestas[] = $file->getFilename();
            }
            //Obtiene todas las empresas
            $empresas = $empresaRepository->findAll();

            //Obtiene todos los profesores
            $profesores = $userRepository->findProfesores();

            return $this->render('archivo/index.html.twig', [
                'pdfFiles' => $pdfFiles,
                'pdfFilesAlumno' => $pdfFilesAlumnos,
                'pdfFilesEncuesta' => $pdfFilesEncuestas,
                'empresas' => $empresas,
                'profesores' => $profesores
            ]);
        }

        #[Route('/datos', name: 'datos')] 
        public function datos(EmpresaRepository $empresaRepository, UserRepository $userRepository, ConvenioRepository $convenioRepository): Response
        {
            //Obtiene el alumno logueado
            $alumno = $this->getUser();

            //Busca el convenio según el alumno
            $convenio = $alumno->getAlumno();

            //Obtiene la ruta donde se encuentral los pdf's
            $pdfDirectory = $this->getParameter('pdf_directory2');

            //Utiliza Finder para buscar archivos PDF en el directorio
            $finder = new Finder();
            $finder->files()->in($pdfDirectory)->name($alumno->getNombre() . $alumno->getApellido1() . $alumno->getApellido2() . '.pdf');

            $pdfFile = null;

            //Obtiene la lista de archivos
            foreach ($finder as $file) {
                $pdfFile = $file->getFilename();
            }

            //Obtiene la ruta donde se encuentral los pdf's
            $pdfDirectory2 = $this->getParameter('pdf_directory3');

            //Utiliza Finder para buscar archivos PDF en el directorio
            $finder2 = new Finder();
            $finder2->files()->in($pdfDirectory2)->name('Encuesta' . $alumno->getNombre() . $alumno->getApellido1() . '.pdf');

            $pdfFileEncuesta = null;

            //Obtiene la lista de archivos
            foreach ($finder2 as $file) {
                $pdfFileEncuesta = $file->getFilename();
            }

            //Obtiene el centro de trabajo
            $centroTrabajo = $convenio->getCentroTrab();

            //Obtiene la empresa del centro de trabajo
            $empresa = $centroTrabajo->getEmpresas()[0];

            return $this->render('archivo/alumno.html.twig', [
                'pdf' => $pdfFile,
                'pdfEncuesta' => $pdfFileEncuesta,
                'convenio' => $convenio,
                'alumno' => $alumno,
                'centroTrabajo' => $centroTrabajo,
                'empresa' => $empresa,

            ]);
        }

        #[Route('/API/subirArchivos', name: "subirArchivos", methods: ['POST'])]
        public function subirArchivos(Request $request): JsonResponse
        {
            //Indica la ruta de las imágenes
            $to_path = "pdf/empresas";

            //Mover el archivo
            $archivo = $request->files->get('file');

            //Si archivo no está vacío
            if ($archivo) 
            {
                //Genera la ruta del archivo
                $nuevoArchivo = $to_path . "/" . $archivo->getClientOriginalName();

                //Si se ha movido
                if ($archivo->move($to_path, $archivo->getClientOriginalName())) 
                {
                    //Devuelve un true
                    return new JsonResponse(["success" => true]);
                } 
                //Si no
                else 
                {
                    //Devuelve un false
                    return new JsonResponse(["success" => false]);
                }
            }
            //En caso de que esté vacío
            else 
            {
                return new JsonResponse(["success" => false, "error" => "No se ha proporcionado ningún archivo."]);
            }
            
        }

        #[Route('/API/subirEncuesta', name: "subirEncuestas", methods: ['POST'])]
        public function subirEncuestas(Request $request): JsonResponse
        {
            //Indica la ruta de las imágenes
            $to_path = "pdf/encuestas";

            //Mover el archivo
            $archivo = $request->files->get('file');

            //Si archivo no está vacío
            if ($archivo) 
            {
                //Genera la ruta del archivo
                $nuevoArchivo = $to_path . "/" . $archivo->getClientOriginalName();

                //Si se ha movido
                if ($archivo->move($to_path, $archivo->getClientOriginalName())) 
                {
                    //Devuelve un true
                    return new JsonResponse(["success" => true]);
                } 
                //Si no
                else 
                {
                    //Devuelve un false
                    return new JsonResponse(["success" => false]);
                }
            }
            //En caso de que esté vacío
            else 
            {
                return new JsonResponse(["success" => false, "error" => "No se ha proporcionado ningún archivo."]);
            }
        }
    }
?>