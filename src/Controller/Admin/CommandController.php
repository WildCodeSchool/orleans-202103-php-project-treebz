<?php

namespace App\Controller\Admin;

use App\Form\SearchCommandType;
use App\Repository\CommandRepository;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
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
        HttpFoundationRequest $request
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
}
