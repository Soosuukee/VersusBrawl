<?php

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
        $teamSlugs = [
            'aacade',
            'alphawolves',
            'apexwarden',
            'arcademaster',
            'arctichowl',
            'berserkers',
            'blazeauthority',
            'cobraclan',
            'crimsonvortex',
            'crimsonblades',
            'dragons',
            'emberreign',
            'falcon',
            'frostbitecollective',
            'gecko',
            'grimreapers',
            'inferno',
            'ironwolves',
            'lunarlegion',
            'neontempest',
            'neontitans',
            'novahounds',
            'onyx',
            'oxen',
            'phantomcore',
            'phoenixclaw',
            'polar',
            'pyros',
            'rebels',
            'rhinos',
            'scorpion',
            'shadowsyndicate',
            'shadowfoxes',
            'sharks',
            'thunderbolts',
            'titandrifters',
            'titanslayers',
            'valiant',
            'valianthawks',
            'valor',
            'venomunit',
            'victorysquadron',
            'voidraptors',
            'volcano',
            'vortex',
            'wildcats'
        ];

        $usernames = [];
        for ($i = 1; $i <= 99; $i++) {
            $usernames[] = 'player' . $i;
        }

        shuffle($usernames);
        $userIndex = 0;

        foreach ($teamSlugs as $slug) {
            /** @var Team $team */
            $team = $this->getReference('team_' . $slug, Team::class);

            $teamSize = random_int(3, 6);
            $remaining = count($usernames) - $userIndex;

            if ($remaining <= 0) break;

            $teamSize = min($teamSize, $remaining);

            for ($i = 0; $i < $teamSize; $i++) {
                $username = $usernames[$userIndex];
                $userIndex++;

                /** @var User $user */
                $user = $this->getReference('user_' . $username, User::class);

                $member = new TeamMember();
                $member->setPlayer($user);
                $member->setTeam($team);
                $member->setIsCaptain($i === 0);

                $manager->persist($member);
            }
        }

        $manager->flush();
    }
}
