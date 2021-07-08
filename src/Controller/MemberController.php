<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Member;
use App\Entity\Command;
use App\Form\MemberType;
use App\Service\GameCard;
use App\Repository\MemberRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* @Route("/creez-votre-jeu/membre")
*/
class MemberController extends AbstractController
{
    /**
     * @Route("/{command<^[0-9]+$>}", name="member_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(Command $command, MemberRepository $memberRepository, GameCard $gameCard): Response
    {

         /** @var User */
         $user = $this->getUser();
        if (!$user->getCommands()->contains($command)) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette commande");
        }

        $priceGame = 0;
        try {
            $priceGame = $gameCard->priceGame($command);
        } catch (Exception $e) {
            $this->addFlash('danger', $e->getMessage());
        }

        return $this->render('member/index.html.twig', [
            'command' => $command,
            'priceGame' => $priceGame,
        ]);
    }

    /**
     * @Route("/new/{command<^[0-9]+$>}", name="member_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Command $command, Request $request): Response
    {
        $member = new Member();

         /** @var User */
         $user = $this->getUser();
        if (!$user->getCommands()->contains($command)) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette commande");
        }

        if (count($command->getMembers() ?? []) >= GameCard::GAME_MAX) {
            $this->addFlash('danger', 'Vous avez atteint la limite de ' . GameCard::GAME_MAX . ' membres.');
            return $this->redirectToRoute('member_index', ['command' => $command->getId() ?? []]);
        }

        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $member->setCommand($command);
            $member->setName(strtoupper($member->getname()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->flush();

            return $this->redirectToRoute('member_index', ['command' => $command->getId()]);
        }

        return $this->render('member/new.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
            'command' => $command,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="member_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
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

         /** @var User */
         $user = $this->getUser();
        if (!$user->getCommands()->contains($command)) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette commande");
        }

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
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function delete(Request $request, Member $member): Response
    {
        /**
         * @var Command
         */
        $command = $member->getCommand();
        $commandId = $command->getId();

         /** @var User */
         $user = $this->getUser();
        if (!$user->getCommands()->contains($command)) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette commande");
        }

        if ($this->isCsrfTokenValid('delete' . $member->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($member);
            $entityManager->flush();
        }

        return $this->redirectToRoute('member_index', ['command' => $commandId]);
    }

    /**
     * @Route("/{id}", name="member_show", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function show(Member $member): Response
    {
        return $this->render('member/show.html.twig', [
            'member' => $member,
        ]);
    }
}
