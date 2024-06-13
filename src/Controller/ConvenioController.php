<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConvenioController extends AbstractController
{
    #[Route('/convenio', name: 'app_convenio')]
    public function index(): Response
    {
        return $this->render('convenio/index.html.twig', [
            'controller_name' => 'ConvenioController',
        ]);
    }
}
