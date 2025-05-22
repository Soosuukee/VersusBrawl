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
        $admin = $manager->getRepository(User::class)->findOneBy(['email' => 'admin@versusbrawl.test']);

        $fortnite = $manager->getRepository(Game::class)->findOneBy(['slug' => 'fortnite']);
        $lol = $manager->getRepository(Game::class)->findOneBy(['slug' => 'league-of-legends']);
        $dota2 = $manager->getRepository(Game::class)->findOneBy(['slug' => 'dota-2']);

        $events = [
            [
                'name' => 'Fortnite Zone Wars 3v3',
                'game' => $fortnite,
                'category' => 'creative',
                'mode' => 'zone_wars',
                'format' => '3v3',
                'image' => 'fortnite_event.jpg',
                'scoringMode' => 'standard',
                'description' => 'Tournoi Fortnite Zone Wars 3v3.',
                'date' => new \DateTime('+5 days'),
                'requiredPlayers' => 6,
            ],
            [
                'name' => 'League of Legends Summoners Rift',
                'game' => $lol,
                'category' => 'default',
                'mode' => 'summoners_rift',
                'format' => null,
                'image' => 'lol_event.jpg',
                'scoringMode' => 'standard',
                'description' => 'Tournoi LoL classique.',
                'date' => new \DateTime('+10 days'),
                'requiredPlayers' => 5,
            ],
            [
                'name' => 'Dota 2 All Pick Clash',
                'game' => $dota2,
                'category' => 'default',
                'mode' => 'all_pick',
                'format' => null,
                'image' => 'dota2_event.jpg',
                'scoringMode' => 'standard',
                'description' => 'Tournoi All Pick sur Dota 2.',
                'date' => new \DateTime('+12 days'),
                'requiredPlayers' => 5,
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
