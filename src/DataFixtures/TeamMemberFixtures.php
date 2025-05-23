<?php
// src/DataFixtures/TeamMemberFixtures.php

namespace App\DataFixtures;

use App\Entity\Team;
use App\Entity\TeamMember;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TeamMemberFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public static function getGroups(): array
    {
        return ['teams_and_members'];
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class, TeamFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $teams = [
            'alpha_wolves' => ['player1', 'player2', 'player3'],
            'crimson_blades' => ['player4', 'player5', 'player6'],
            'neon_titans' => ['player7', 'player8', 'player9'],
            'shadow_foxes' => ['player10', 'player11', 'player12'],
        ];

        foreach ($teams as $teamSlug => $usernames) {
            /** @var Team $team */
            $team = $this->getReference('team_' . $teamSlug, Team::class);

            foreach ($usernames as $index => $username) {
                /** @var User $user */
                $user = $this->getReference('user_' . $username, User::class);

                $member = new TeamMember();
                $member->setPlayer($user);
                $member->setTeam($team);
                $member->setIsCaptain($index === 0);

                $manager->persist($member);
            }
        }

        $manager->flush();
    }
}
