<?php

namespace App\Controller;

use App\Form\UserDetailType;
use App\Entity\User;
use App\Repository\CommandRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/mon-compte")
 */
class UserDetailController extends AbstractController
{

    /**
     * @Route("/modifier", name="user_detail_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request): Response
    {
        /** @var User */
        $user = $this->getUser();
        $form = $this->createForm(UserDetailType::class, $user->getUserDetail());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Vos données ont été modifiées avec succès !');

            return $this->redirect($request->getUri());
        }
        return $this->render('user_detail/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/histrorique-des-commandes", name="command_history", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function showCommand(CommandRepository $commandRepository): Response
    {
        return $this->render('user_detail/commandHistory.html.twig');
    }
}
