<?php

namespace App\Controller\Admin;

use App\Entity\Command;
use App\Repository\CommandRepository;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchCommandType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/commande", name="command_")
 */
class CommandController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index(
        CommandRepository $commandRepository,
        StatusRepository $statusRepository,
        Request $request
    ): Response {
        $form = $this->createForm(SearchCommandType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            $command = $commandRepository->findLikeProjectName($search);
        } else {
            $command = $commandRepository->findAll();
        }

        return $this->render('admin/command/index.html.twig', [
            'commands' => $command,
            'status' => $statusRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="change_status", methods={"POST"})
     */
    public function changeStatus(Request $request, Command $command, StatusRepository $statusRepository): Response
    {
        if ($this->isCsrfTokenValid('change_status' . $command->getId(), $request->request->get('_token'))) {
            $status = $statusRepository->find($request->request->get('status'));
            $command->setStatus($status);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('command_index');
    }
}
