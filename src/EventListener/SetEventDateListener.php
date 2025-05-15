<?php

namespace App\EventListener;

use App\Entity\Event;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;

#[AsDoctrineListener(event: 'prePersist')]
class SetEventDateListener
{
    public function prePersist(\Doctrine\Persistence\Event\LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof Event) {
            return;
        }

        if ($entity->getCreatedAt() === null) {
            $entity->setCreatedAt(new \DateTimeImmutable());
        }
    }
}
