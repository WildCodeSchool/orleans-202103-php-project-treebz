<?php

namespace App\Controller;

use App\Entity\Command;
use App\Repository\ThemeRepository;
use App\Repository\MemberRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/creez-votre-jeu", name="gamecreation_")
 */

class PreviewController extends AbstractController
{
    /**
     * @Route("/prévisualisation-du-jeu/{command_id}/", name="preview", methods={"GET","POST"})
     * @ParamConverter("command", class="App\Entity\Command", options={"mapping": {"command_id": "id"}})
     */

    public function index(
        MemberRepository $memberRepository,
        Command $command,
        ThemeRepository $themeRepository
    ): Response {

        return $this->render('gameCreation/preview.html.twig', [
            'command' => $command,
        ]);
    }
}
