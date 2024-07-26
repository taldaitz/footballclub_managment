<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Goal;
use App\Entity\Player;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GoalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('time', null, [
                'widget' => 'single_text',
                'label' => 'Date/Heure'
            ])
            ->add('game', EntityType::class, [
                'class' => Game::class,
                'choice_label' => 'displayName',
                'label' => 'Match',
            ])
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'Equipe',
            ])
            ->add('player', EntityType::class, [
                'class' => Player::class,
                'choice_label' => 'fullname',
                'label' => 'Joueur',
            ])
            ->add('save', SubmitType::class, [
                'label' => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Goal::class,
        ]);
    }
}
