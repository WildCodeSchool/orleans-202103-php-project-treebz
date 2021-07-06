<?php

namespace App\Controller;

use App\Entity\Command;
use App\Repository\ThemeRepository;
use App\Repository\MemberRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CardController extends AbstractController
{
    /**
     * @Route("/carte/{id}/", name="card", methods={"GET","POST"})
     */
    public function index(
        MemberRepository $memberRepository,
        Command $command,
        ThemeRepository $themeRepository
    ): Response {
        return $this->render('card.html.twig', [
            'members' => $memberRepository->findAll(),
            'command' => $command,
            'theme' => $themeRepository->findAll(),
        ]);
    }
}
