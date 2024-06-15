<?php
    namespace App\Controller;

    use Symfony\Component\HttpFoundation\{Response, Request, JsonResponse};
    use Symfony\Component\Routing\Annotation\Route;
    use App\Repository\{EmpresaRepository, UserRepository};
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

            //Obtiene todas las empresas
            $empresas = $empresaRepository->findAll();

            //Obtiene todos los profesores
            $profesores = $userRepository->findProfesores();

            return $this->render('archivo/index.html.twig', [
                'pdfFiles' => $pdfFiles,
                'empresas' => $empresas,
                'profesores' => $profesores
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
    }
?>