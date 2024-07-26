<?php

namespace App\Service;

use App\Entity\Game;
use App\Repository\RefereeRepository;
use App\Repository\TeamRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class GameManager 
{
    private TeamRepository $teamRepository;
    private RefereeRepository $refereeRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(TeamRepository $teamRepository, RefereeRepository $refereeRepository, EntityManagerInterface $entityManager)
    {
        $this->teamRepository = $teamRepository;
        $this->refereeRepository = $refereeRepository;
        $this->entityManager = $entityManager;
    }

    public function generateGames() 
    {

        $teams = $this->teamRepository->findAll();
        $referee = $this->refereeRepository->find(1);

        $dateGame = new DateTime();

        foreach($teams as $teamIn) {

            foreach($teams as $teamOut) {

                if ($teamIn === $teamOut) continue;

                $dateGame->modify('+1 day');

                $game = new Game();
                $game->setTeamIn($teamIn)
                    ->setTeamOut($teamOut)
                    ->setDate($dateGame)
                    ->setReferee($referee)
                ;

                $this->entityManager->persist($game);
                $this->entityManager->flush();
            }
        }
    }
}