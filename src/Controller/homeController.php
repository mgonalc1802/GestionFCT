<?php
    namespace App\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    //Metalenguaje que ejecuta nuestros ficheros buscando los atributos necesarios      
    class homeController extends AbstractController
    {
        //Más adelante indicaremos como poner el verbo Get, Post..
        #[Route('/', name: 'home')] 
        public function home(): Response
        {
            return $this->render('home.html.twig');
        }
    }
?>