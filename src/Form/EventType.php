<?php

namespace App\Form;

use App\Entity\Game;
use App\Constant\GameModes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('date')
            ->add('image')
            ->add('requiredPlayers')
            ->add('description')
            ->add('game', EntityType::class, [
                'class' => Game::class,
                'choice_label' => 'name',
                'label' => 'Jeu',
            ])
            ->add('category', ChoiceType::class, [
                'choices' => self::getAllCategories(),
                'label' => 'Catégorie de mode',
            ])
            ->add('mode', ChoiceType::class, [
                'choices' => self::getAllModes(),
                'label' => 'Mode de jeu',
            ])
            ->add('scoringMode');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => \App\Entity\Event::class,
        ]);
    }

    private static function getAllCategories(): array
    {
        $categories = [];
        foreach (GameModes::MODES as $modes) {
            foreach (array_keys($modes) as $category) {
                $label = $category === 'default' ? 'Mode standard' : ucfirst(str_replace('_', ' ', $category));
                $categories[$label] = $category;
            }
        }
        return $categories;
    }

    private static function getAllModes(): array
    {
        $modes = [];
        foreach (GameModes::MODES as $modesByCategory) {
            foreach ($modesByCategory as $list) {
                foreach ($list as $mode) {
                    $label = ucfirst(str_replace('_', ' ', $mode));
                    $modes[$label] = $mode;
                }
            }
        }
        return $modes;
    }
}
