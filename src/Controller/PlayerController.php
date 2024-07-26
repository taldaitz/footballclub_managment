<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PlayerController extends AbstractController
{
    #[Route('/player/details/{id}', name: 'app_player_details')]
    public function details(Player $player): Response
    {
        return $this->render('player/details.html.twig', [
            'player' => $player
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/player/new', name: 'app_player_new')]
    public function create(Request $request, EntityManagerInterface $entityManager) 
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $player = $form->getData();

            $entityManager->persist($player);
            $entityManager->flush();

            return $this->redirectToRoute('app_player_details', ['id' => $player->getId()]);
        }

        return $this->render('/player/new.html.twig', ['form' => $form]);
    }

    #[Route('/player/modify/{id}', name: 'app_player_edit')]
    public function update(Player $player, Request $request, EntityManagerInterface $entityManager) : Response
    {

        $form = $this->createForm(PlayerType::class, $player);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $player = $form->getData();

            $entityManager->persist($player);
            $entityManager->flush();

            return $this->redirectToRoute('app_player_details', ['id' => $player->getId()]);
        }

        return $this->render('/player/edit.html.twig', ['form' => $form]);
    }
}
