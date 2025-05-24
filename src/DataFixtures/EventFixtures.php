<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Game;
use App\Entity\User;
use App\Traits\EntityValidationTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Constant\GameModes;

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

        $imageMap = [
            'fortnite' => 'fncs-global.jpg',
            'counter-strike-2' => 'PGL-CS2-Major-Copenhagen-2024.jpg',
            'league-of-legends' => 'LoLWorlds2024.avif',
            'super-smash-bros' => 'Smash-Ultimate-Summit-5.avif',
            'valorant' => 'valorant-champions.jpg',
        ];

        $usedImageGames = [];
        $allSlugs = GameModes::getAllGameSlugs();
        $startDate = (new \DateTime('2024-05-24'))->getTimestamp();
        $endDate = (new \DateTime('2026-05-24'))->getTimestamp();

        foreach ($allSlugs as $slug) {
            $game = $manager->getRepository(Game::class)->findOneBy(['slug' => $slug]);
            if (!$game) continue;

            $paths = GameModes::getFullPathOptions($slug);
            if (empty($paths)) continue;

            shuffle($paths);
            $count = 0;

            foreach ($paths as $path) {
                $isSolo = in_array($path['format'], ['1v1']) ||
                    ($slug === 'teamfight-tactics' && $path['mode'] === 'free_for_all') ||
                    ($slug === 'pokemon' && in_array($path['mode'], ['smogon_singles', 'vgc_2v2_double_battles']));

                $event = new Event();
                $event->setName(ucfirst($slug) . ' ' . ucfirst($path['mode']) . ' Event ' . ($count + 1));
                $event->setGame($game);
                $event->setCreatedBy($admin);
                $event->setCategory($path['category']);
                $event->setMode($path['mode']);
                $event->setFormat($path['format']);
                $event->setScoringMode('standard');
                $event->setDescription('Tournoi ' . $path['mode'] . ' sur ' . ucfirst($slug));
                $event->setDate((new \DateTime())->setTimestamp(rand($startDate, $endDate)));
                $event->setRequiredPlayers($isSolo ? 1 : rand(2, 10));
                $event->setIsSolo($isSolo);

                if (!in_array($slug, $usedImageGames) && isset($imageMap[$slug])) {
                    $event->setImage($imageMap[$slug]);
                    $usedImageGames[] = $slug;
                }

                $this->validateOrFail($event);
                $manager->persist($event);
                $count++;

                if ($count >= 2 && !$isSolo) break;
                if ($isSolo && $count >= 3) break;
            }
        }

        $manager->flush();
    }
}
