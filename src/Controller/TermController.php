<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TermController extends AbstractController
{
    public function termOfService(): Response
    {
        return $this->render('terms/termOfService.html.twig');
    }
}
