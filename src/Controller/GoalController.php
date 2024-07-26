<?php

namespace App\Controller;

use App\Entity\Goal;
use App\Form\GoalType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GoalController extends AbstractController
{
    #[Route('/goal/new', name: 'app_goal_new')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $goal = new Goal();
        $form = $this->createForm(GoalType::class, $goal);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($goal);
            $entityManager->flush();

            return $this->redirectToRoute('app_game_details', ['id' => $goal->getGame()->getId()]);
        }

        return $this->render('goal/new.html.twig', [
            'form' => $form
        ]);
    }
}
