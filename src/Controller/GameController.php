<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Repository\TeamRepository;
use App\Service\GameManager;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GameController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/game/generate', name: 'app_game_generate')]
    public function generate(GameManager $gameManager): Response
    {
        $gameManager->generateGames();

        return $this->redirectToRoute('app_calendar');
    }

    #[Route('/calendar', name: 'app_calendar')]
    public function calendar(GameRepository $gameRepository) : Response
    {
        $games = $gameRepository->findAll();

        return $this->render('game/calendar.html.twig', ['games' => $games]);
    }

    #[Route('/game/{id}', name: 'app_game_details')]
    public function details(Game $game) : Response
    {
        return $this->render('/game/details.html.twig', ['game' => $game]);
    }
}
