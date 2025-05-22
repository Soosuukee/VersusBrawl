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
            [
                'name' => 'fortnite',
                'slug' => 'fortnite',
                'type' => 'battle_royale',
                'color' => '#4ade80',
                'isAvailable' => true,
                'platforms' => ['PC', 'PlayStation', 'Xbox', 'Switch'],
            ],
            [
                'name' => 'valorant',
                'slug' => 'valorant',
                'type' => 'fps',
                'color' => '#f87171',
                'isAvailable' => true,
                'platforms' => ['PC'],
            ],
            [
                'name' => 'dota2',
                'slug' => 'dota-2',
                'type' => 'moba',
                'color' => '#60a5fa',
                'isAvailable' => false,
                'platforms' => ['PC'],
            ],
            [
                'name' => 'supersmashbros',
                'slug' => 'super-smash-bros',
                'type' => 'combat',
                'color' => '#facc15',
                'isAvailable' => true,
                'platforms' => ['Switch'],
            ],
            [
                'name' => 'tomclancysrainbowsixsiege',
                'slug' => 'tom-clancy-s-rainbow-six-siege',
                'type' => 'fps',
                'color' => '#38bdf8',
                'isAvailable' => true,
                'platforms' => ['PC', 'PlayStation', 'Xbox'],
            ],
            [
                'name' => 'leagueoflegends',
                'slug' => 'league-of-legends',
                'type' => 'moba',
                'color' => '#9333ea',
                'isAvailable' => true,
                'platforms' => ['PC'],
            ],
        ];

        foreach ($games as $data) {
            $game = new Game();
            $imgName = $data['name'];

            $game->setName($imgName);
            $game->setSlug($data['slug']);
            $game->setType($data['type']);
            $game->setColor($data['color']);
            $game->setIsAvailable($data['isAvailable']);
            $game->setPlatforms($data['platforms']);

            $game->setIcon($imgName . '.png');
            $game->setBanner($imgName . '_banner.png');
            $game->setHeroes($imgName . '_heroes.png');

            $manager->persist($game);
        }

        $manager->flush();
    }
}
