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
            ['name' => 'Apex Legends', 'slug' => 'apex-legends', 'image' => 'apexlegends.png', 'color' => '#E95F4C'],
            ['name' => 'Counter Strike 2', 'slug' => 'counter-strike-2', 'image' => 'counterstrike2.png', 'color' => '#FFD700'],
            ['name' => 'Fortnite', 'slug' => 'fortnite', 'image' => 'fortnite.png', 'color' => '#9146FF'],
            ['name' => 'Marvel Rivals', 'slug' => 'marvel-rivals', 'image' => 'marvelrivals.png', 'color' => '#FF5050'],
            ['name' => 'Rainbow Six Siege', 'slug' => 'rainbow-six-siege', 'image' => 'tomclancysrainbowsixsiege.png', 'color' => '#2E8B57'],
            ['name' => 'Valorant', 'slug' => 'valorant', 'image' => 'valorant.png', 'color' => '#FA4454'],
            ['name' => 'Dota 2', 'slug' => 'dota-2', 'image' => 'dota.png', 'color' => '#C0392B'],
            ['name' => 'Fragpunk', 'slug' => 'fragpunk', 'image' => 'fragpunk.png', 'color' => '#8E44AD'],
            ['name' => 'League of Legends', 'slug' => 'league-of-legends', 'image' => 'leagueoflegends.png', 'color' => '#1E2A38'],
            ['name' => 'Overwatch 2', 'slug' => 'overwatch-2', 'image' => 'overwatch.png', 'color' => '#FF9E1B'],
            ['name' => 'Super Smash Bros', 'slug' => 'smash-bros', 'image' => 'smashbros.png', 'color' => '#FFDAB9'],
            ['name' => 'Pokémon', 'slug' => 'pokemon', 'image' => 'pokemon.png', 'color' => '#FFCB05'],
            ['name' => 'Rocket League', 'slug' => 'rocket-league', 'image' => 'rocketleague.png', 'color' => '#005A9C'],
            ['name' => 'Teamfight Tactics', 'slug' => 'teamfight-tactics', 'image' => 'teamfighttactics.png', 'color' => '#9B59B6'],
        ];

        foreach ($games as $data) {
            $game = new Game();
            $game->setName($data['name']);
            $game->setSlug($data['slug']);
            $game->setImage($data['image']);
            $game->setColor($data['color']);
            $manager->persist($game);

            // Facultatif : utile si tu veux réutiliser ces jeux dans d'autres fixtures
            $this->addReference('game-' . $data['slug'], $game);
        }

        $manager->flush();
    }
}
