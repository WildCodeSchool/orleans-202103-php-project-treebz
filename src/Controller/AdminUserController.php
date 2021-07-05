<?php

namespace App\Controller;

use App\Entity\UserDetail;
use App\Entity\User;
use App\Form\UserType;
use App\Form\UserDetailType;
use App\Repository\UserDetailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/clients")
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("/", name="admin_user_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(UserDetailRepository $userDetailRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'user_details' => $userDetailRepository->findBy([], ['lastname' => 'ASC'])
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="admin_user_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, UserDetail $userDetail): Response
    {
        $form = $this->createForm(UserDetailType::class, $userDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/edit.html.twig', [
            'user_detail' => $userDetail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, UserDetail $userDetail): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userDetail->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userDetail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_user_index');
    }
}
