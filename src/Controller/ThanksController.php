<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Command;
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
        EntityManagerInterface $entityManager
    ): Response {
        $status = $statusRepository->findOneByName(['name' => 'Commandée']);

        $command->setStatus($status);
        $entityManager->flush();
        // Redirection to the second step page
        return $this->render('gameCreation/thanks.html.twig');
    }
}
