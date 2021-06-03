<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/lesreglesdujeu", name="gamerules_")
*/

class RulesController extends AbstractController
{
    /**
    * @Route("/", name="index")
    */

    public function index(): Response
    {

        return $this->render('gamerules/index.html.twig');
    }
}
