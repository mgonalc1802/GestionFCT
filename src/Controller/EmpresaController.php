<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Response};
use App\Repository\{EmpresaRepository};
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\{Empresa};
class EmpresaController extends AbstractController
{
    #[Route('/datosEmpresa', name: 'datosEmpresa')]
    public function datosEmpresa(EmpresaRepository $empresaRepository): Response
    {
        //Obtiene todas las Empresas
        $centros = $empresaRepository->findAll();


        return $this->render('empresa/index.html.twig', [
            'centros' => $centros
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
