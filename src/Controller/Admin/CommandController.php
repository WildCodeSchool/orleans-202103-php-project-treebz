<?php

namespace App\Controller\Admin;

use App\Entity\Command;
use App\Entity\Status;
use App\Form\ChangeStatusOrderType;
use App\Repository\CommandRepository;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(CommandRepository $commandRepository, StatusRepository $statusRepository): Response
    {


        return $this->render('admin/command/index.html.twig', [
            'commands' => $commandRepository->findAll(),
            'status' => $statusRepository->findAll(),
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
