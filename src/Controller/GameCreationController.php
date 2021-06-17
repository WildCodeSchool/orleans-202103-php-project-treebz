<?php

namespace App\Controller;

use App\Entity\Command;
use App\Entity\Theme;
use App\Form\CommandType;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/creez-votre-jeu", name="gamecreation_")
*/

class GameCreationController extends AbstractController
{

    /**
    * @Route("/", name="index")
    */

    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commandForm = new Command();
        $form = $this->createForm(CommandType::class, $commandForm);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commandForm);
            $entityManager->flush();
            // Redirection to the second step page
            return $this->redirectToRoute('home');
        }
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
