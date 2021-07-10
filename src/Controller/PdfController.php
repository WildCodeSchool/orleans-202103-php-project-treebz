<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
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
    ): void {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled', true);
        set_time_limit(100);
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf.html.twig', [
            'command' => $command,
        ]);
        // Load HTML to Dompdf
        $dompdf->loadhtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("7familles.pdf", [
            "Attachment" => false
        ]);
    }
}
