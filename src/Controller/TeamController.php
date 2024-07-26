<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TeamController extends AbstractController
{
    #[Route('/team/compose', name: 'app_team_compose')]
    public function compose(EntityManagerInterface $entityManager): Response
    {

        $lyon = new Team();
        $paris = new Team();
        $nantes = new Team();
        $bordeaux = new Team();

        $lyon->setName('Lyon FC')->setCity('Lyon');
        $paris->setName('Olympique de Paris')->setCity('Paris');
        $nantes->setName('Nantes RC')->setCity('Nantes');
        $bordeaux->setName('Bordeaux Saint-Germain')->setCity('Bordeaux');

        $lyon_player1 = new Player();
        $lyon_player2 = new Player();
        $lyon_player3 = new Player();

        $lyon_player1->setLastname('Lyonnais')->setFirstname('François')->setNumber(1)->setPosition('Attaquant')->setTeam($lyon);
        $lyon_player2->setLastname('Lyonnais')->setFirstname('Robert')->setNumber(2)->setPosition('Défenseur')->setTeam($lyon);
        $lyon_player3->setLastname('Lyonnaise')->setFirstname('Jean-Claude')->setNumber(5)->setPosition('Gardien de but')->setTeam($lyon);

        $paris_player1 = new Player();
        $paris_player2 = new Player();
        $paris_player3 = new Player();

        $paris_player1->setLastname('Parisien')->setFirstname('François')->setNumber(1)->setPosition('Attaquant')->setTeam($paris);
        $paris_player2->setLastname('Parisien')->setFirstname('Robert')->setNumber(2)->setPosition('Défenseur')->setTeam($paris);
        $paris_player3->setLastname('Parisienne')->setFirstname('Jean-Claude')->setNumber(5)->setPosition('Gardien de but')->setTeam($paris);

        $nantes_player1 = new Player();
        $nantes_player2 = new Player();
        $nantes_player3 = new Player();

        $nantes_player1->setLastname('Nantais')->setFirstname('François')->setNumber(1)->setPosition('Attaquant')->setTeam($nantes);
        $nantes_player2->setLastname('Nantais')->setFirstname('Robert')->setNumber(2)->setPosition('Défenseur')->setTeam($nantes);
        $nantes_player3->setLastname('Nantaise')->setFirstname('Jean-Claude')->setNumber(5)->setPosition('Gardien de but')->setTeam($nantes);

        $bordeaux_player1 = new Player();
        $bordeaux_player2 = new Player();
        $bordeaux_player3 = new Player();

        $bordeaux_player1->setLastname('Bordelais')->setFirstname('François')->setNumber(1)->setPosition('Attaquant')->setTeam($bordeaux);
        $bordeaux_player2->setLastname('Bordelais')->setFirstname('Robert')->setNumber(2)->setPosition('Défenseur')->setTeam($bordeaux);
        $bordeaux_player3->setLastname('Bordelaise')->setFirstname('Jean-Claude')->setNumber(5)->setPosition('Gardien de but')->setTeam($bordeaux);


        $entityManager->persist($lyon);
        $entityManager->persist($paris);
        $entityManager->persist($nantes);
        $entityManager->persist($bordeaux);

        $entityManager->persist($lyon_player1);
        $entityManager->persist($lyon_player2);
        $entityManager->persist($lyon_player3);
        $entityManager->persist($paris_player1);
        $entityManager->persist($paris_player2);
        $entityManager->persist($paris_player3);
        $entityManager->persist($nantes_player1);
        $entityManager->persist($nantes_player2);
        $entityManager->persist($nantes_player3);
        $entityManager->persist($bordeaux_player1);
        $entityManager->persist($bordeaux_player2);
        $entityManager->persist($bordeaux_player3);

        $entityManager->flush();

        return new Response('Toutes les équipes sont créées');
    }


    #[Route('/team/list', name: 'app_team_list')]
    public function list(TeamRepository $teamRepository) : Response
    {

        $teams = $teamRepository->findAll();

        $result = '<ul>';
        foreach($teams as $team)
        {
            $result .= '<li>'; 
            $result .= $team->getName() . ' : ';
            
            $players = $team->getPlayers();

            foreach($players as $player) {
                $result .= $player->getFirstname() . ' ' . $player->getLastname() . ', ';
            }

            $result .='</li>';
        }
        $result .= '</ul>';
        return new Response($result);
    }

    #[Route('/team/presentation', name: 'app_team_presentation')]
    #[Route('/', name: 'app_homepage')]
    public function presentation(TeamRepository $teamRepository) : Response
    {
        $teams = $teamRepository->findAll();

        return $this->render('/team/presentation.html.twig', ['teams' => $teams]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/team/new', name: 'app_team_new')]
    public function create(Request $request, EntityManagerInterface $entityManager) 
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $team = $form->getData();

            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('app_team_presentation');
        }

        return $this->render('/team/new.html.twig', ['form' => $form]);
    }
}
