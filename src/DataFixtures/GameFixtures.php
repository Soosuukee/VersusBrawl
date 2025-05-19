<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class GameFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['games'];
    }

    public function load(ObjectManager $manager): void
    {
        $games = [
            ['name' => 'Apex Legends', 'slug' => 'apex-legends', 'color' => '#E95F4C', 'type' => 'Battle Royale', 'isAvailable' => true],
            ['name' => 'Counter Strike 2', 'slug' => 'counter-strike-2', 'color' => '#FFD700', 'type' => 'FPS', 'isAvailable' => true],
            ['name' => 'Fortnite', 'slug' => 'fortnite', 'color' => '#9146FF', 'type' => 'Battle Royale', 'isAvailable' => true],
            ['name' => 'Marvel Rivals', 'slug' => 'marvel-rivals', 'color' => '#FF5050', 'type' => 'MOBA', 'isAvailable' => false],
            ['name' => 'Tom Clancy\'s Rainbow Six Siege', 'slug' => 'rainbow-six-siege', 'color' => '#2E8B57', 'type' => 'FPS', 'isAvailable' => true],
            ['name' => 'Valorant', 'slug' => 'valorant', 'color' => '#FA4454', 'type' => 'FPS', 'isAvailable' => true],
            ['name' => 'Dota 2', 'slug' => 'dota-2', 'color' => '#C0392B', 'type' => 'MOBA', 'isAvailable' => true],
            ['name' => 'Fragpunk', 'slug' => 'fragpunk', 'color' => '#8E44AD', 'type' => 'FPS', 'isAvailable' => false],
            ['name' => 'League of Legends', 'slug' => 'league-of-legends', 'color' => '#1E2A38', 'type' => 'MOBA', 'isAvailable' => true],
            ['name' => 'Overwatch 2', 'slug' => 'overwatch-2', 'color' => '#FF9E1B', 'type' => 'FPS', 'isAvailable' => true],
            ['name' => 'Super Smash Bros', 'slug' => 'smash-bros', 'color' => '#FFDAB9', 'type' => 'Fighting', 'isAvailable' => true],
            ['name' => 'Pokémon', 'slug' => 'pokemon', 'color' => '#FFCB05', 'type' => 'Strategy', 'isAvailable' => false],
            ['name' => 'Rocket League', 'slug' => 'rocket-league', 'color' => '#005A9C', 'type' => 'Sports', 'isAvailable' => true],
            ['name' => 'Teamfight Tactics', 'slug' => 'teamfight-tactics', 'color' => '#9B59B6', 'type' => 'Auto Battler', 'isAvailable' => true],
        ];

        foreach ($games as $data) {
            $game = new Game();
            $game->setName($data['name']);
            $game->setSlug($data['slug']);
            $game->setColor($data['color']);
            $game->setType($data['type']);
            $game->setIsAvailable($data['isAvailable']);

            // Nom de base pour les images (nom tout collé, sans apostrophes ni espaces)
            $imageBase = strtolower(preg_replace('/[^a-z0-9]/i', '', $data['name']));

            $game->setIcon($imageBase . '.png');
            $game->setBanner($imageBase . '_banner.png');
            $game->setHeroes($imageBase . '_heroes.png');

            $manager->persist($game);
            $this->addReference('game-' . $data['slug'], $game);
        }

        $manager->flush();
    }
}
