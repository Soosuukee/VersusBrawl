<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['users'];
    }
    public function load(ObjectManager $manager): void
    {
        // Admin
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@versusbrawl.test');
        $admin->setPassword('adminpass'); // en clair !
        $admin->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($admin);

        // Capitaine
        $captain = new User();
        $captain->setUsername('captain');
        $captain->setEmail('captain@versusbrawl.test');
        $captain->setPassword('captainpass');
        $captain->setRoles(['ROLE_CAPTAIN']);
        $manager->persist($captain);

        // Joueur simple
        $player = new User();
        $player->setUsername('player');
        $player->setEmail('player@versusbrawl.test');
        $player->setPassword('playerpass');
        $player->setRoles(['ROLE_USER']);
        $manager->persist($player);

        $alreadyHashedPassword = '$2y$13$VjfYc7j1s7i0jTK1ySeWreP3uqkPZsH5nU1xgSD6YmJeaVTCB.tSa'; // hash de "testpass"

        $testUser = new User();
        $testUser->setUsername('testUser');
        $testUser->setEmail('hashed@versusbrawl.test');
        $testUser->setPassword($alreadyHashedPassword);
        $testUser->setRoles(['ROLE_USER']);
        $manager->persist($testUser);

        $manager->flush();
    }
}
