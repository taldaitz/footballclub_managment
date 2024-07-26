<?php

namespace App\Controller;

use App\Entity\Referee;
use App\Form\RefereeType;
use App\Repository\RefereeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/referee')]
class RefereeController extends AbstractController
{
    #[Route('/', name: 'app_referee_index', methods: ['GET'])]
    public function index(RefereeRepository $refereeRepository): Response
    {
        return $this->render('referee/index.html.twig', [
            'referees' => $refereeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_referee_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $referee = new Referee();
        $form = $this->createForm(RefereeType::class, $referee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($referee);
            $entityManager->flush();

            return $this->redirectToRoute('app_referee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('referee/new.html.twig', [
            'referee' => $referee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_referee_show', methods: ['GET'])]
    public function show(Referee $referee): Response
    {
        return $this->render('referee/show.html.twig', [
            'referee' => $referee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_referee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Referee $referee, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RefereeType::class, $referee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_referee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('referee/edit.html.twig', [
            'referee' => $referee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_referee_delete', methods: ['POST'])]
    public function delete(Request $request, Referee $referee, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$referee->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($referee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_referee_index', [], Response::HTTP_SEE_OTHER);
    }
}
