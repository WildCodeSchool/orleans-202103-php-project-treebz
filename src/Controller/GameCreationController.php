<?php

namespace App\Controller;

use App\Entity\Command;
use App\Entity\Theme;
use App\Form\CommandType;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
* @Route("/creervotrejeu", name="gamecreation_")
*/

class GameCreationController extends AbstractController
{
    /**
    * @Route("/", name="index")
    */

    public function index(): Response
    {
        $commandForm = new Command();
        $form = $this->createForm(CommandType::class, $commandForm);
        return $this->render('gameCreation/index.html.twig', ["form" => $form->createView(),]);
    }

     /**
    * @Route("/choisissez-votre-theme", name="choose_theme")
    */
    public function chooseTheme(ThemeRepository $themeRepository): Response
    {
        return $this->render('gameCreation/theme.html.twig', ['themes' => $themeRepository->findAll()]);
    }
}
