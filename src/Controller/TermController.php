<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TermController extends AbstractController
{
    /**
     * @Route("/condition_generale_d\'utilisation", name="termOfService")
     */
    public function termOfService(): Response
    {
        return $this->render('terms/termOfService.html.twig');
    }
}
