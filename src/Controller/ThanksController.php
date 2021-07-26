<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Command;
use App\Service\GameCard;
use App\DataFixtures\StatusFixtures;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/thanks/{command<^[0-9]+$>}", name="thanks", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(
        Command $command,
        StatusRepository $statusRepository,
        EntityManagerInterface $entityManager,
        GameCard $gameCard
    ): Response {

        /** @var User */
        $user = $this->getUser();
        if (!$user->getCommands()->contains($command)) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette commande");
        }
        $priceGame = $gameCard->priceGame($command);
        $command->setPrice($priceGame);

        $status = $statusRepository->findOneByName(['name' => StatusFixtures::STATUS[1]['status']]);
        $command->setStatus($status);

        $entityManager->flush();
        // Redirection to the second step page
        return $this->render('gameCreation/thanks.html.twig');
    }
}
