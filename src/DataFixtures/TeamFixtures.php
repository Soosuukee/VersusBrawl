<?php

namespace App\DataFixtures;

use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class TeamFixtures extends Fixture implements FixtureGroupInterface
{

    public const TEAM_DATA = [
        ['name' => 'Alpha Wolves', 'image' => 'alphawolves.png'],
        ['name' => 'Crimson Blades', 'image' => 'crimsonblades.png'],
        ['name' => 'Neon Titans', 'image' => 'neontitans.png'],
        ['name' => 'Shadow Foxes', 'image' => 'shadowfoxes.png'],
    ];
    public static function getGroups(): array
    {
        return ['teams_and_members'];
    }
    public function load(ObjectManager $manager): void
    {
        $admin = $manager->getRepository(User::class)->findOneBy(['email' => 'admin@versusbrawl.test']);

        if (!$admin) {
            throw new \RuntimeException("Admin user not found. Please load UserFixtures first.");
        }


        foreach (self::TEAM_DATA as $data) {
            $team = new Team();
            $team->setName($data['name']);
            $team->setImage($data['image']);

            $manager->persist($team);
            $this->addReference('team_' . $data['name'], $team);
        }
        $manager->flush();
    }
}
