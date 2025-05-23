<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Event;
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
            ->add('mode', ChoiceType::class, [
                'choices' => self::getFlatChoices('fortnite'),
                'label' => 'Mode de jeu',
                'placeholder' => 'Choisis un mode',
            ])
            ->add('scoringMode');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
    private static function getFlatChoices(string $slug): array
    {
        $choices = [];
        $options = GameModes::getFullPathOptions($slug);

        foreach ($options as $opt) {
            $parts = [];

            if ($opt['category'] !== 'default') {
                $parts[] = $opt['category'];
            }

            $parts[] = $opt['mode'];

            if ($opt['format']) {
                $parts[] = $opt['format'];
            }

            $label = implode(' > ', $parts);
            $value = implode('|', [$opt['category'], $opt['mode'], $opt['format'] ?? '']);

            $choices[$label] = $value;
        }

        return $choices;
    }
}
