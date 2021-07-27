<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Theme;
use App\Form\GameType;
use App\Entity\Command;
use App\Form\CommandType;
use App\Service\GameCard;
use App\Form\SelectThemesType;
use App\Repository\ThemeRepository;
use App\Repository\StatusRepository;
use App\Repository\CommandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        CommandRepository $commandRepository,
        StatusRepository $statusRepository
    ): Response {
        $command = new Command();
        /** @var User */
        $user = $this->getUser();
        $status = $statusRepository->findOneByName(['name' => GameCard::STATUS[0]['status']]);
        $lastCommand = $commandRepository->findOneBy(
            ['user' => $user, 'status' => $status->getId()],
            ['createdAt' => 'desc']
        );
        $form = $this->createForm(CommandType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command->setUser($user);
            $command->setStatus($status);
            $entityManager->persist($command);
            $entityManager->flush();
            // Redirection to the second step page
            return $this->redirectToRoute('member_index', ['command' => $command->getId()]);
        }

        return $this->render('gameCreation/index.html.twig', [
            "form" => $form->createView(),
            "lastCommand" => $lastCommand,
        ]);
    }

    /**
     * @Route("/modifier/{id}/", name="editGame", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function editCommand(Request $request, Command $command, GameCard $gameCard): Response
    {
        $form = $this->createForm(GameType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($gameCard->statutOrdered($command) === true) {
                $this->getDoctrine()->getManager()->flush();
            }
            return $this->redirectToRoute('member_index', ['command' => $command->getId()]);
        }
        if ($gameCard->statutOrdered($command) === false) {
            $this->addFlash('danger', "La commande est déjà validée, vous ne pouvez plus la modifier");
        }
        return $this->render('gameCreation/index.html.twig', [
            'command' => $command,
            'form' => $form->createView(),
            'lastCommand' => "",
        ]);
    }

    /**
     * @Route("/choisissez-vos-familles/{id}/", name="choose_theme", methods={"GET","POST"})
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
            if ($gameCard->statutOrdered($command) === false) {
                return $this->redirectToRoute('gamecreation_preview', ['id' => $command->getId()]);
            }
            if (count($command->getSelectedThemes()) > 0) {
                $entityManager->persist($command);
                $entityManager->flush();
                // Redirection to the same page
                return $this->redirectToRoute('gamecreation_preview', ['id' => $command->getId()]);
            } else {
                $this->addFlash('danger', 'Veuillez sélectionner au moins une famille.');
            }
        }

        if ($gameCard->statutOrdered($command) === false) {
            $this->addFlash('danger', "La commande est déjà validée, vous ne pouvez plus la modifier");
        }

        return $this->render('gameCreation/theme.html.twig', [
            'themes' => $themeRepository->findAll(),
            'command' => $command,
            'form' => $form->createView(),
            'priceGame' => $priceGame,
        ]);
    }
}
