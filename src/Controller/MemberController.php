<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Command;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Cropperjs\Form\CropperType;
use Symfony\UX\Cropperjs\Factory\CropperInterface;

/**
* @Route("/creez-votre-jeu/membre")
*/
class MemberController extends AbstractController
{
    /**
     * @Route("/{command<^[0-9]+$>}", name="member_index", methods={"GET"})
     */
    public function index(Command $command, MemberRepository $memberRepository): Response
    {
        return $this->render('member/index.html.twig', [
            'command' => $command,
        ]);
    }

    /**
     * @Route("/new/{command<^[0-9]+$>}", name="member_new", methods={"GET","POST"})
     */
    public function new(CropperInterface $cropper, Command $command, Request $request): Response
    {
        $member = new Member();
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);
        $crop = $cropper->createCrop('/build/images/portrait.f9fbaac2.jpg');
        $crop->setCroppedMaxSize(2000, 1500);

        $cropForm = $this->createFormBuilder(['crop' => $crop])
            ->add('crop', CropperType::class, [
                'public_url' => '/build/images/portrait.f9fbaac2.jpg',
                'aspect_ratio' => 2000 / 1500,
            ])
            ->getForm()
        ;

        if ($form->isSubmitted() && $form->isValid()) {
            $member->setCommand($command);
            $member->setName(strtoupper($member->getname()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->flush();

            return $this->redirectToRoute('member_index', ['command' => $command->getId()]);
        }

        $cropForm->handleRequest($request);

        if ($cropForm->isSubmitted() && $cropForm->isValid()) {
            $crop->getCroppedImage();
            $crop->getCroppedThumbnail(200, 150);
        }

        return $this->render('member/new.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
            'cropper' => $cropForm->createView(),
            'command' => $command,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="member_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Member $member): Response
    {

        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        /**
         * @var Command
         */
        $command = $member->getCommand();
        $commandId = $command->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $member->setCommand($command);
            $member->setName(strtoupper($member->getname()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->flush();
            return $this->redirectToRoute('member_index', ['command' => $commandId]);
        }

        return $this->render('member/edit.html.twig', [
            'member' => $member,
            'command' => $commandId,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_delete", methods={"POST"})
     */
    public function delete(Request $request, Member $member): Response
    {
        /**
         * @var Command
         */
        $command = $member->getCommand();
        $commandId = $command->getId();

        if ($this->isCsrfTokenValid('delete' . $member->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($member);
            $entityManager->flush();
        }

        return $this->redirectToRoute('member_index', ['command' => $commandId]);
    }

    /**
     * @Route("/{id}", name="member_show", methods={"GET"})
     */
    public function show(Member $member): Response
    {
        return $this->render('member/show.html.twig', [
            'member' => $member,
        ]);
    }
}
