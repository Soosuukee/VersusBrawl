<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Game;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // 1. Créer un utilisateur (créateur d’événement)
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setUsername('admin');
        $user->setPassword($this->hasher->hashPassword($user, 'password'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        // 2. Créer un jeu
        $game = new Game();
        $game->setName('League of Legends');
        $game->setImage('lol.jpg');
        $manager->persist($game);

        // 3. Créer un événement
        $event = new Event();
        $event->setName('Tournoi LoL - Avril');
        $event->setDate(new \DateTime('+1 month')); // Date du tournoi
        $event->setImage('default.jpg');
        $event->setGame($game);
        $event->setCreatedBy($user);
        // Pas besoin de setCreatedAt(), le listener le fait

        $manager->persist($event);

        $manager->flush();
    }
}
