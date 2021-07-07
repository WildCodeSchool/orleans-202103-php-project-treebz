<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\UserDetail;
use App\Entity\SearchClient;
use App\Form\UserDetailType;
use App\Form\SearchClientType;
use App\Repository\UserDetailRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/clients")
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("/", name="admin_user_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(Request $request, UserDetailRepository $userDetailRepository): Response
    {
        $searchClient = new SearchClient();
        $form = $this->createForm(SearchClientType::class, $searchClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clients = $userDetailRepository->findBySearch($searchClient);
        }
        return $this->render('admin/user/index.html.twig', [
            'user_details' => $clients ?? $userDetailRepository->findBy([], ['lastname' => 'ASC']),
            'form' => $form->createView(),
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
