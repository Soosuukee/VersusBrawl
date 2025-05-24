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
        return ['teams_and_members'];
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            ['username' => 'admin', 'email' => 'admin@versusbrawl.test', 'password' => 'adminpass', 'roles' => ['ROLE_SUPER_ADMIN']],
            ['username' => 'captain', 'email' => 'captain@versusbrawl.test', 'password' => 'captainpass', 'roles' => ['ROLE_USER']],
            ['username' => 'testUser', 'email' => 'hashed@versusbrawl.test', 'password' => '$2y$13$VjfYc7j1s7i0jTK1ySeWreP3uqkPZsH5nU1xgSD6YmJeaVTCB.tSa', 'roles' => ['ROLE_USER'], 'hashed' => true],
        ];

        $usersWithIcons = [
            ['username' => 'kaiser', 'email' => 'kaiser@versusbrawl.test', 'password' => 'kaisersecret', 'roles' => ['ROLE_USER'], 'icon' => 'kaiser.jpg'],
            ['username' => 'ezreal', 'email' => 'ezreal@versusbrawl.test', 'password' => 'ezrealpass', 'roles' => ['ROLE_USER'], 'icon' => 'ezreal.jpg'],
            ['username' => 'ultron', 'email' => 'ultron@versusbrawl.test', 'password' => 'ultronpass', 'roles' => ['ROLE_USER'], 'icon' => 'ultron.jpg'],
            ['username' => 'yoru', 'email' => 'yoru@versusbrawl.test', 'password' => 'yorupass', 'roles' => ['ROLE_USER'], 'icon' => 'yoru.jpg'],
            ['username' => 'cs_player', 'email' => 'cs@versusbrawl.test', 'password' => 'cspass', 'roles' => ['ROLE_USER'], 'icon' => 'cs.jpg'],
        ];

        // 99 joueurs sans image
        for ($i = 1; $i <= 99; $i++) {
            $users[] = ['username' => "player$i", 'email' => "player$i@versusbrawl.test", 'password' => "playerpass$i", 'roles' => ['ROLE_USER']];
        }

        $allUsers = array_merge($users, $usersWithIcons);

        foreach ($allUsers as $data) {
            $user = new User();
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);
            $user->setRoles($data['roles']);

            if (isset($data['icon'])) {
                $user->setIcon($data['icon']);
            }

            $manager->persist($user);
            $this->addReference('user_' . $data['username'], $user);
        }

        $manager->flush();
    }
}
