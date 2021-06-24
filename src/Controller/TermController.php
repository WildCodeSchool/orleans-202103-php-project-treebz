<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TermController extends AbstractController
{
    /**
     * @Route("/conditions-generales-dutilisation", name="termOfService")
     */
    public function termOfService(): Response
    {
        return $this->render('terms/termOfService.html.twig');
    }
}
