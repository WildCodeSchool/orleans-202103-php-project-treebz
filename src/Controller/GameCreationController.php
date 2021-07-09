<?php

namespace App\Controller;

use App\Entity\Command;
use App\Entity\Theme;
use App\Entity\User;
use App\Form\CommandType;
use App\Form\SelectThemesType;
use App\Repository\StatusRepository;
use App\Repository\ThemeRepository;
use App\Service\GameCard;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/creez-votre-jeu", name="gamecreation_")
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */

class GameCreationController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        StatusRepository $statusRepository
    ): Response {
        $command = new Command();
        /** @var User */
        $user = $this->getUser();
        $form = $this->createForm(CommandType::class, $command);
        $form->handleRequest($request);
        $status = $statusRepository->findOneByName(['name' => 'En cours']);

        if ($form->isSubmitted() && $form->isValid()) {
            $command->setUser($user);
            $command->setStatus($status);
            $entityManager->persist($command);
            $entityManager->flush();
            // Redirection to the second step page
            return $this->redirectToRoute('member_index', ['command' => $command->getId()]);
        }

        return $this->render('gameCreation/index.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @Route("/choisissez-votre-theme/{command_id}/", name="choose_theme", methods={"GET","POST"})
     * @ParamConverter("command", class="App\Entity\Command", options={"mapping": {"command_id": "id"}})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function chooseTheme(
        Command $command,
        Request $request,
        ThemeRepository $themeRepository,
        EntityManagerInterface $entityManager,
        GameCard $gameCard
    ): Response {

        /** @var User */
        $user = $this->getUser();
        if (!$user->getCommands()->contains($command)) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette commande");
        }

        $form = $this->createForm(SelectThemesType::class, $command);
        $form->handleRequest($request);

        $priceGame = $gameCard->priceGame($command);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($command);
            $entityManager->flush();
            // Redirection to the same page
            return $this->redirect($request->getUri());
        }
        return $this->render('gameCreation/theme.html.twig', [
            'themes' => $themeRepository->findAll(),
            'command' => $command,
            'form' => $form->createView(),
            'priceGame' => $priceGame,
        ]);
    }
}
