<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsDoctrineListener(event: 'prePersist')]
class UserPasswordListener
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {}

    public function prePersist(PrePersistEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof User) {
            return;
        }

        $plainPassword = $entity->getPassword();

        if ($plainPassword && !str_starts_with($plainPassword, '$2y$')) {
            $entity->setPassword(
                $this->passwordHasher->hashPassword($entity, $plainPassword)
            );
        }
    }
}
