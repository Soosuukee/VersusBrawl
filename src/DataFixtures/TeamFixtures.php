<?php

namespace App\DataFixtures;

use App\Entity\Team;
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
        $filenames = [
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

        foreach ($filenames as $slug) {
            $team = new Team();

            // Nom lisible (Alpha Wolves, etc.)
            $name = ucwords(preg_replace('/(?<!^)([A-Z])/', ' $1', $slug));
            $image = $slug . '.png';

            $team->setName($name);
            $team->setImage($image);

            $manager->persist($team);
            $this->addReference('team_' . $slug, $team);
        }

        $manager->flush();
    }
}
