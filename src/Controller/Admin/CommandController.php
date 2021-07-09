<?php

namespace App\Controller\Admin;

use App\Entity\Status;
use App\Entity\Command;
use App\Form\StatusSearchType;
use App\Form\SearchCommandType;
use App\Repository\StatusRepository;
use App\Repository\CommandRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

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

       // $statusInfo = 'En cours';
        $form = $this->createForm(SearchCommandType::class);
        $form->handleRequest($request);
        //$status = new Status();
        $formStatus = $this->createForm(StatusSearchType::class);
        $formStatus->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            $commands = $commandRepository->findLikeProjectName($search);
        } else {
            $commands = $commandRepository->findAll();
        }

        if ($formStatus->isSubmitted() &&  $formStatus->isValid()) {
            $input = $formStatus->getData()['input'];

            $commands = $commandRepository->findByStatus(['status' => $input]);
        }

        return $this->render('admin/command/index.html.twig', [
            'commands' => $commands,
            'status' => $statusRepository->findAll(),
            'form' => $form->createView(),
            'formStatus' => $formStatus->createView(),
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
