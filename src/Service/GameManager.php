<?php

namespace App\Service;

use App\Entity\Game;
use App\Repository\TeamRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class GameManager 
{
    private TeamRepository $teamRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(TeamRepository $teamRepository, EntityManagerInterface $entityManager)
    {
        $this->teamRepository = $teamRepository;
        $this->entityManager = $entityManager;
    }

    public function generateGames() 
    {

        $teams = $this->teamRepository->findAll();

        $dateGame = new DateTime();

        foreach($teams as $teamIn) {

            foreach($teams as $teamOut) {

                if ($teamIn === $teamOut) continue;

                $dateGame->modify('+1 day');

                $game = new Game();
                $game->setTeamIn($teamIn)
                    ->setTeamOut($teamOut)
                    ->setDate($dateGame)
                ;

                $this->entityManager->persist($game);
                $this->entityManager->flush();
            }
        }
    }
}