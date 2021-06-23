<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Entity\Command;
use App\Form\CommandType;
use App\Form\SelectThemesType;
use App\Repository\ThemeRepository;
use App\Repository\CommandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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

            return $this->redirectToRoute('member_index', ['command' => $commandForm->getId()]);
        }

        return $this->render('gameCreation/index.html.twig', ["form" => $form->createView(),]);
    }

    /**
     * @Route("/choisissez-votre-theme/{command_id}/", name="choose_theme", methods={"GET","POST"})
     * @ParamConverter("command", class="App\Entity\Command", options={"mapping": {"command_id": "id"}})
     */
    public function chooseTheme(
        Command $command,
        Request $request,
        ThemeRepository $themeRepository,
        EntityManagerInterface $entityManager
    ): Response {

        $form = $this->createForm(SelectThemesType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($command);
            $entityManager->flush();
            // Redirection to the same page
            return $this->redirect($request->getUri());
        } return $this->render('gameCreation/theme.html.twig', [
            'themes' => $themeRepository->findAll(),
            'command' => $command,
            'form' => $form->createView(),

        ]);
    }
}
