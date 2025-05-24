<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class GameFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['games'];
    }

    public function load(ObjectManager $manager): void
    {
        $games = [
            ['name' => 'Apex Legends', 'slug' => 'apex-legends', 'type' => 'battle_royale', 'color' => '#f97316', 'isAvailable' => true, 'platforms' => ['PC', 'PlayStation', 'Xbox']],
            ['name' => 'Counter Strike 2', 'slug' => 'counter-strike-2', 'type' => 'fps', 'color' => '#f43f5e', 'isAvailable' => true, 'platforms' => ['PC']],
            ['name' => 'Fortnite', 'slug' => 'fortnite', 'type' => 'battle_royale', 'color' => '#4ade80', 'isAvailable' => true, 'platforms' => ['PC', 'PlayStation', 'Xbox', 'Switch', 'Mobile']],
            ['name' => 'Marvel Rivals', 'slug' => 'marvel-rivals', 'type' => 'fps', 'color' => '#22d3ee', 'isAvailable' => true, 'platforms' => ['PC', 'PlayStation', 'Xbox']],
            ['name' => 'Tom Clancy\'s Rainbow Six Siege', 'slug' => 'tom-clancy-s-rainbow-six-siege', 'type' => 'fps', 'color' => '#38bdf8', 'isAvailable' => true, 'platforms' => ['PC', 'PlayStation', 'Xbox']],
            ['name' => 'Valorant', 'slug' => 'valorant', 'type' => 'fps', 'color' => '#f87171', 'isAvailable' => true, 'platforms' => ['PC', 'PlayStation', 'Xbox']],
            ['name' => 'Dota 2', 'slug' => 'dota-2', 'type' => 'moba', 'color' => '#60a5fa', 'isAvailable' => true, 'platforms' => ['PC']],
            ['name' => 'Fragpunk', 'slug' => 'fragpunk', 'type' => 'fps', 'color' => '#e879f9', 'isAvailable' => true, 'platforms' => ['PC', 'PlayStation', 'Xbox']],
            ['name' => 'League of Legends', 'slug' => 'league-of-legends', 'type' => 'moba', 'color' => '#9333ea', 'isAvailable' => true, 'platforms' => ['PC']],
            ['name' => 'Overwatch 2', 'slug' => 'overwatch-2', 'type' => 'fps', 'color' => '#fbbf24', 'isAvailable' => true, 'platforms' => ['PC', 'PlayStation', 'Xbox']],
            ['name' => 'Super Smash Bros', 'slug' => 'super-smash-bros', 'type' => 'combat', 'color' => '#facc15', 'isAvailable' => true, 'platforms' => ['Switch', 'PC (emulator)']],
            ['name' => 'Pokémon', 'slug' => 'pokemon', 'type' => 'strategie', 'color' => '#34d399', 'isAvailable' => true, 'platforms' => ['Switch', 'PC (emulator)']],
            ['name' => 'Rocket League', 'slug' => 'rocket-league', 'type' => 'sport', 'color' => '#0ea5e9', 'isAvailable' => true, 'platforms' => ['PC', 'PlayStation', 'Xbox', 'Switch']],
            ['name' => 'Teamfight Tactics', 'slug' => 'teamfight-tactics', 'type' => 'auto_battler', 'color' => '#8b5cf6', 'isAvailable' => true, 'platforms' => ['PC', 'Mobile']],
        ];

        foreach ($games as $data) {
            $game = new Game();

            $slug = $data['slug'];

            $game->setName($data['name']);
            $game->setSlug($slug);
            $game->setType($data['type']);
            $game->setColor($data['color']);
            $game->setIsAvailable($data['isAvailable']);
            $game->setPlatforms($data['platforms']);

            $game->setIcon($slug . '.png');
            $game->setBanner($slug . '_banner.png');
            $game->setHeroes($slug . '_heroes.png');

            $manager->persist($game);
        }

        $manager->flush();
    }
}
