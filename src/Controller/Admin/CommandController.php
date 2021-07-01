<?php

namespace App\Admin\Controller;

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
    public function index(): Response
    {
        return $this->render('admin/command/index.html.twig', [
            'controller_name' => 'CommandController',
        ]);
    }
}
