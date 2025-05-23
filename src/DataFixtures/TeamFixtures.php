<?php
// src/DataFixtures/TeamFixtures.php

namespace App\DataFixtures;

use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TeamFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public static function getGroups(): array
    {
        return ['teams_and_members'];
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $teams = [
            ['name' => 'Alpha Wolves', 'image' => 'alphawolves.png'],
            ['name' => 'Crimson Blades', 'image' => 'crimsonblades.png'],
            ['name' => 'Neon Titans', 'image' => 'neontitans.png'],
            ['name' => 'Shadow Foxes', 'image' => 'shadowfoxes.png'],
        ];

        foreach ($teams as $data) {
            $team = new Team();
            $team->setName($data['name']);
            $team->setImage($data['image']);

            $manager->persist($team);
            $slug = strtolower(str_replace(' ', '_', $data['name']));
            $this->addReference('team_' . $slug, $team);
        }

        $manager->flush();
    }
}
