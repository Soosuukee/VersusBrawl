<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Game;
use App\Entity\User;
use App\Traits\EntityValidationTrait;
use App\Traits\GameMetadataTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
// use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Constant\GameModes;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    use EntityValidationTrait;
    use GameMetadataTrait;

    // public static function getGroups(): array
    // {
    //     return ['events'];
    // }

    public function getDependencies(): array
    {
        return [
            GameFixtures::class,
            UserFixtures::class,
        ];
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

        $nonSoloGames = [
            'valorant',
            'counter-strike-2',
            'overwatch-2',
            'league-of-legends',
            'dota-2',
            'rocket-league',
            'fragpunk',
            'marvel-rivals',
            'tom-clancy-s-rainbow-six-siege'
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
                $isSolo = !$this->isGameAlwaysTeamBased($slug) && (
                    in_array($path['format'], ['1v1']) ||
                    in_array($path['mode'], ['free_for_all', 'deathmatch', 'singles', 'vgc_2v2_double_battles', 'duel'])
                );

                $event = new Event();
                $event->setName(ucfirst($slug) . ' ' . ucfirst($path['mode']) . ' Event ' . ($count + 1));
                $event->setGame($game);
                $event->setCreatedBy($admin);
                $event->setCategory($path['category']);
                $event->setMode($path['mode']);
                $event->setFormat($path['format']);
                $event->setScoringMode('standard');
                $event->setDescription(sprintf('Tournoi %s sur %s', str_replace('_', ' ', $path['mode']), ucfirst(str_replace('-', ' ', $slug))));
                $event->setDate((new \DateTime())->setTimestamp(rand($startDate, $endDate)));
                $event->setIsSolo($isSolo);

                if ($isSolo) {
                    $event->setRequiredPlayers(1);
                } elseif ($slug === 'valorant' && $path['mode'] === 'plant_defuse') {
                    $event->setRequiredPlayers(5);
                } elseif ($slug === 'counter-strike-2' && $path['mode'] === 'bomb_defusal') {
                    $event->setRequiredPlayers(5);
                } elseif ($slug === 'rocket-league' && $path['mode'] === 'standard') {
                    $event->setRequiredPlayers(3);
                } elseif ($slug === 'league-of-legends') {
                    $event->setRequiredPlayers(5);
                } elseif ($slug === 'overwatch-2') {
                    $event->setRequiredPlayers(5);
                } elseif ($slug === 'super-smash-bros' && $path['mode'] === 'doubles') {
                    $event->setRequiredPlayers(2);
                } else {
                    $event->setRequiredPlayers(rand(2, 10));
                }

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
