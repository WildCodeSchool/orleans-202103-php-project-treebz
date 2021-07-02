<?php

namespace App\Controller\Admin;

use App\Repository\CommandRepository;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/command", name="command_")
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
            'status' => $statusRepository->findAll()
        ]);
    }
}
