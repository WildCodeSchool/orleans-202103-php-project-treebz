<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Entity\Member;
use App\Entity\Command;
use App\Repository\ThemeRepository;
use App\Repository\MemberRepository;
use App\Repository\CommandRepository;
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

        $themeNumber = '10000';
        $memberNumber = '10000';
        return $this->render('gameCreation/preview.html.twig', [
            'command' => $command,
            'viewTheme' => $themeNumber,
            'memberNumber' => $memberNumber,
        ]);
    }

    /**
     * @Route("/prévisualisation-du-jeu/{command_id}/une-carte", name="preview_one_card", methods={"GET","POST"})
     * @ParamConverter("command", class="App\Entity\Command", options={"mapping": {"command_id": "id"}})
     */

    public function oneCard(
        MemberRepository $memberRepository,
        Command $command,
        ThemeRepository $themeRepository
    ): Response {

        $themeNumber = '1';
        $memberNumber = '1';
        return $this->render('gameCreation/preview.html.twig', [
            'command' => $command,
            'viewTheme' => $themeNumber,
            'memberNumber' => $memberNumber,
        ]);
    }

    /**
     * @Route("/prévisualisation-du-jeu/{command_id}/une-famille", name="preview_one_familly", methods={"GET","POST"})
     * @ParamConverter("command", class="App\Entity\Command", options={"mapping": {"command_id": "id"}})
     */

    public function oneFamilly(
        Command $command,
        CommandRepository $commandRepository
    ): Response {
        $themeNumber = '1';
        $memberNumber = '1000';
        return $this->render('gameCreation/preview.html.twig', [
            'command' => $command,
            'viewTheme' => $themeNumber,
            'memberNumber' => $memberNumber,
        ]);
    }
}
