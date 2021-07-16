<?php

namespace App\Controller;

use App\Entity\Command;
use App\Entity\Member;
use App\Entity\User;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use App\Service\GameCard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Cropperjs\Factory\CropperInterface;
use Symfony\UX\Cropperjs\Form\CropperType;

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
            'members' => $memberRepository->findBy(['command' => $command->getId()], ['cardNumber' => 'ASC']),
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

        $form = $this->createForm(MemberType::class, $member, ['validation_groups' => ['addMember']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $member->setCommand($command);
            $member->setName(strtoupper($member->getname()));
            $member->setCardNumber(count($command->getMembers() ?? []) + 1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->flush();

            return $this->redirectToRoute('member_crop', [
                'command' => $command->getId(),
                'member' => $member->getId(),
            ]);
        }

        return $this->render('member/new.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
            'command' => $command,
        ]);
    }

    /**
     * @Route("/crop/{command<^[0-9]+$>}/{member<^[0-9]+$>}", name="member_crop", methods={"GET","POST"})
     */
    public function crop(Command $command, Member $member, Request $request, CropperInterface $cropper): Response
    {
        /**
         * @var string
         */
        $fileDirectory = $this->getParameter('public_directory');
        /**
         * @var string
         */
        $fileUpload = $this->getParameter('upload_member_directory');
        $filename = $fileDirectory . $fileUpload . $member->getPicture();
        $crop = $cropper->createCrop($filename);
        $crop->setCroppedMaxSize(1500, 2000);

        $form = $this->createFormBuilder(['crop' => $crop])
            ->add('crop', CropperType::class, [
                'public_url' => $fileUpload . $member->getPicture(),
                'initial_aspect_ratio' => 68 / 86,
                'drag_mode' => 'move',
                'crop_box_movable' => false,
                'crop_box_resizable' => false,
                'zoom_on_wheel' => true,
                'zoomable' => true,
                'movable' => true,
                'min_crop_box_width' => 1000,
                'min_crop_box_height' => 1000,
                'min_container_width' => 257,
                'min_container_height' => 325,
            ])
            ->add('validate', SubmitType::class, [
                'label' => 'Valider',
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = ($crop->getCroppedImage());
            //GD Library extension not available with this PHP installation.
            // Be careful, here we are using PHP 7.4, if you change to 8.0, an error can occur
            /** @phpstan-ignore-next-line */
            $resource = (imagecreatefromstring($encoded));
            /** @phpstan-ignore-next-line */
            $resource = imagescale($resource, 257);
            /** @phpstan-ignore-next-line */
            imagejpeg($resource, $filename);
            return $this->redirectToRoute('member_index', ['command' => $command->getId()]);
        }
        return $this->render('member/crop.html.twig', [
            'form' => $form->createView(),
            'command' => $command,
        ]);
    }

    /**
     * @Route("/change_num_carte/{command<^[0-9]+$>}/{member<^[0-9]+$>}/{deplacement}",
     * name="member_change_cardnumber", methods={"POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function changeCardNumber(
        Command $command,
        Member $member,
        string $deplacement,
        Request $request,
        MemberRepository $memberRepository
    ): Response {

        /** @var User */
        $user = $this->getUser();
        if (!$user->getCommands()->contains($command)) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette commande");
        }

        $numCardMember = $member->getCardNumber();

        if ($deplacement !== 'up' && $deplacement !== 'down') {
            $this->addFlash('danger', 'il y a eu un problème de propriété');
            return $this->redirectToRoute('member_index', ['command' => $command->getId()]);
        }

        if ($deplacement === 'up') {
            $numDeplacement = 1;
        } else {
            $numDeplacement = -1;
        }

            /** @var Member */
            $memberReplace = $memberRepository->findOneBy(['command' => $command->getId(),
            'cardNumber' => ($numCardMember + $numDeplacement)]);
            $memberReplace->setCardNumber($numCardMember);
            $member->setCardNumber($numCardMember + $numDeplacement);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

        return $this->redirectToRoute('member_index', ['command' => $command->getId()]);
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
            return $this->redirectToRoute('member_crop', [
                'command' => $command->getId(),
                'member' => $member->getId(),
            ]);
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
        $numberRemove = $member->getCardNumber();

        /** @var User */
        $user = $this->getUser();
        if (!$user->getCommands()->contains($command)) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette commande");
        }

        if ($this->isCsrfTokenValid('delete' . $member->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($member);

            foreach ($command->getMembers() as $member) {
                if ($member->getCardNumber() > $numberRemove) {
                    $member->setCardNumber($member->getCardNumber() - 1);
                }
            }
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
