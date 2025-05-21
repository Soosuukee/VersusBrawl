<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Game;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Traits\EntityValidationTrait;

class EventFixtures extends Fixture implements FixtureGroupInterface
{
    use EntityValidationTrait;

    public static function getGroups(): array
    {
        return ['events'];
    }

    public function __construct(ValidatorInterface $validator)
    {
        $this->setValidator($validator);
    }

    public function load(ObjectManager $manager): void
    {
        // Récupération de l'utilisateur admin
        $admin = $manager->getRepository(User::class)->findOneBy(['email' => 'admin@versusbrawl.test']);

        // Récupération des jeux par slug
        $fortnite = $manager->getRepository(Game::class)->findOneBy(['slug' => 'fortnite']);
        $valorant = $manager->getRepository(Game::class)->findOneBy(['slug' => 'valorant']);

        $events = [
            [
                'name' => '', // Viol : nom vide
                'game' => $fortnite,
                'category' => 'wrong_category', // Viol : catégorie inexistante
                'mode' => 'deathmatch', // Viol : mode incohérent pour la catégorie
                'format' => '10v10', // Viol : format inexistant
                'image' => '', // Viol : vide
                'scoringMode' => '', // Viol : vide
                'description' => '', // Viol : vide
                'date' => new \DateTime('-5 days'), // Event dans le passé
                'requiredPlayers' => 0, // Viol : nombre incohérent
            ],
            [
                'name' => 'Broken Event 2',
                'game' => $valorant,
                'category' => 'default',
                'mode' => 'solo', // Viol : solo n'est pas un mode Valorant
                'format' => '1v1',
                'image' => 'broken.jpg',
                'scoringMode' => 'unknown',
                'description' => 'Ce tournoi ne respecte rien.',
                'date' => new \DateTime('-1 day'),
                'requiredPlayers' => -3,
            ]
        ];

        foreach ($events as $data) {
            $event = new Event();
            $event->setName($data['name']);
            $event->setGame($data['game']);
            $event->setCreatedBy($admin);
            $event->setDate($data['date']);
            $event->setCategory($data['category']);
            $event->setMode($data['mode']);
            $event->setFormat($data['format']);
            $event->setScoringMode($data['scoringMode']);
            $event->setDescription($data['description']);
            $event->setImage($data['image']);
            $event->setRequiredPlayers($data['requiredPlayers']);

            $this->validateOrFail($event);

            $manager->persist($event);
        }

        $manager->flush();
    }
}
