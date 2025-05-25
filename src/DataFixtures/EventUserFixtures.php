<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\EventUser;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
// use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class EventUserFixtures extends Fixture implements DependentFixtureInterface
{
    // public static function getGroups(): array
    // {
    //     return ['event_users'];
    // }

    public function getDependencies(): array
    {
        return [
            EventFixtures::class,
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $events = $manager->getRepository(Event::class)->findBy(['isSolo' => true]);
        $users = $manager->getRepository(User::class)->findAll();

        $now = new \DateTimeImmutable();

        $userUsage = [];

        foreach ($events as $event) {
            shuffle($users);
            $numUsers = rand(4, 10);
            $selectedUsers = array_slice($users, 0, $numUsers);

            foreach ($selectedUsers as $user) {
                $usage = $userUsage[$user->getId()] ?? 0;
                if ($usage >= 2) continue;
                $eventUser = new EventUser();
                $eventUser->setEvent($event);
                $eventUser->setUser($user);

                $isValidated = $event->getDate() < $now;
                $eventUser->setIsValidated($isValidated);

                $eventUser->setPointsTotal(rand(0, 1000));
                $eventUser->setRanking(null);
                $eventUser->setNote(null);

                $manager->persist($eventUser);
                $userUsage[$user->getId()] = $usage + 1;
            }
        }

        $manager->flush();
    }
}
