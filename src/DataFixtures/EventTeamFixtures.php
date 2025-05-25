<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\EventTeam;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class EventTeamFixtures extends Fixture implements DependentFixtureInterface
{
    // public static function getGroups(): array
    // {
    //     return ['event_teams'];
    // }

    public function getDependencies(): array
    {
        return [
            EventFixtures::class,
            TeamFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $events = $manager->getRepository(Event::class)->findBy(['isSolo' => false]);
        $teams = $manager->getRepository(Team::class)->findAll();

        $validTeams = array_filter($teams, fn($team) => $team->getTeamMembers()->count() > 0);
        $now = new \DateTimeImmutable();

        foreach ($events as $event) {
            shuffle($validTeams);
            $numTeams = rand(3, 8);
            $selectedTeams = array_slice($validTeams, 0, $numTeams);

            foreach ($selectedTeams as $team) {
                $participation = new EventTeam();
                $participation->setEvent($event);
                $participation->setTeam($team);

                $isValidated = $event->getDate() < $now;
                $participation->setIsValidated($isValidated);

                $participation->setPointsTotal(rand(0, 1000));
                $participation->setRanking(null);
                $participation->setNote(null);

                $manager->persist($participation);
            }
        }

        $manager->flush();
    }
}
