<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TermController extends AbstractController
{
    /**
     * @Route("/protection-des-donnees", name="termsDataProtection")
     */
    public function index(): Response
    {
        return $this->render('terms/policy.html.twig');
    }

    /**
     * @Route("/conditions-generales-dutilisation", name="termOfService")
     */
    public function termOfService(): Response
    {
        return $this->render('terms/termOfService.html.twig');
    }
}
