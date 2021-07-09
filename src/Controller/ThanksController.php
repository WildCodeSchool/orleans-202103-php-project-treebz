<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/creez-votre-jeu", name="gamecreation_")
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */

class ThanksController extends AbstractController
{
    /**
     * @Route("/thanks", name="thanks")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(): Response
    {
        return $this->render('gameCreation/thanks.html.twig');
    }
}
