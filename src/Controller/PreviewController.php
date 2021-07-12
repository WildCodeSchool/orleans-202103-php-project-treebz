<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Command;
use App\Entity\ShippingAddress;
use App\Form\SelectAddressType;
use Doctrine\ORM\EntityManager;
use App\Form\ShippingAddressType;
use App\Repository\ThemeRepository;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/creez-votre-jeu", name="gamecreation_")
 */

class PreviewController extends AbstractController
{
    /**
     * @Route("/prévisualisation-du-jeu/{id}/", name="preview", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */

    public function index(
        MemberRepository $memberRepository,
        Command $command,
        ThemeRepository $themeRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {

        /** @var User */
        $user = $this->getUser();

        if (!$user->getCommands()->contains($command)) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette commande");
        }

        $shippingAddress = new ShippingAddress();

        $formSelectAddress = $this->createForm(SelectAddressType::class, $command, ['user' => $user]);
        $formSelectAddress->handleRequest($request);

        if ($formSelectAddress->isSubmitted() && $formSelectAddress->isValid()) {
            $entityManager->persist($command);
            $entityManager->flush();
            // Redirection to the same page
            return $this->redirect($request->getUri());
        }

        $formAddAddress = $this->createForm(ShippingAddressType::class, $shippingAddress);
        $formAddAddress->handleRequest($request);

        if ($formAddAddress->isSubmitted() && $formAddAddress->isValid()) {
            $shippingAddress->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shippingAddress);
            $entityManager->flush();
            $this->addFlash('success', 'Adresse ajoutée avec succès');
            return $this->redirect($request->getUri());
        }

        return $this->render('gameCreation/preview.html.twig', [
            'command' => $command,
            'shipping_address' => $shippingAddress,
            'formAddAddress' => $formAddAddress->createView(),
            'formSelectAddress' => $formSelectAddress->createView(),
        ]);
    }
}
