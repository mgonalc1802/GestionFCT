<?php

namespace App\Controller;

use App\Service\MessageGenerator;
use App\Service\EmailService;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request, JsonResponse};
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('/API/enviarEmail', name: 'enviarEmail', methods: ['POST'])]
    public function sendEmail(Request $request, MailerInterface $mailer): JsonResponse
    {
        //Obtiene el JSON enviado
        $data = json_decode($request->getContent(), true);

        //Distingue cada atributo del JSON
        $remitente = $data['profesorRemitente'];
        $destinatario = $data['empresaDestinataria'];
        $rutaPDF = $data['rutaPDF'];

        //Ruta al archivo PDF que deseas adjuntar
        $pdfDirectory = $this->getParameter('pdf_directory');
        $pdfFilePath = $pdfDirectory . '/' . $rutaPDF;

        //Si no existe el pdf en la ruta
        if (!file_exists($pdfFilePath)) {
            //Devuelve un JSON
            return new JsonResponse('Archivo PDF no encontrado.', 404);
        }

        //Genera el email
        $email = (new Email())
            ->from($remitente)
            ->to($destinatario)
            ->subject('PDF')
            ->text('Te envío esta documentación para que sea rellenada o para mostrarle información.')
            ->html('<p>Te envío esta documentación para que sea rellenada o para mostrarle información.</p>')
            ->attachFromPath($pdfFilePath);

        //Realiza un try catch para el manejo de errores
        try {
            $mailer->send($email);
            return new JsonResponse('Correo enviado con archivo adjunto: ' . $pdfFilePath, 200);
        } catch (\Exception $e) {
            $logger->error('Error al enviar el correo: ' . $e->getMessage());
            return new JsonResponse('Error al enviar el correo.', 500);
        }
    }
}

?>