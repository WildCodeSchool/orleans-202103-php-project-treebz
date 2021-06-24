<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MemberRepository;

class CardController extends AbstractController
{
    /**
     * @Route("/carte", name="card")
     */
    public function index(MemberRepository $memberRepository): Response
    {
        return $this->render('card.html.twig', [
            'members' => $memberRepository->findAll(),
        ]);
    }
}
