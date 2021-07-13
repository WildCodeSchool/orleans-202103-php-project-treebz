<?php

namespace App\Controller;

use App\Entity\Command;
use App\Repository\ThemeRepository;
use App\Repository\MemberRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PdfController extends AbstractController
{
     /**
     * @Route("/pdf/{id}", name="pdf", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */

    public function index(
        MemberRepository $memberRepository,
        Command $command,
        ThemeRepository $themeRepository
    ): Response {
        return $this->render('pdf.html.twig', [
                'command' => $command,
        ]);
    }

     /**
     * @Route("/back-pdf/{id}", name="backPdf", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */

    public function back(
        MemberRepository $memberRepository,
        Command $command,
        ThemeRepository $themeRepository
    ): Response {
        return $this->render('back_pdf.html.twig', [
                'command' => $command,
        ]);
    }
}
