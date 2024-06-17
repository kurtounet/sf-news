<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HashUserPasswordSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist
        ];
    }

    public function prePersist(PrePersistEventArgs $event)
    {
        $entity = $event->getObject();

        // Type guard
        if (!$entity instanceof User) {
            return;
        }

        $entity->setPassword(
            $this->hasher->hashPassword(
                $entity,
                $entity->getPassword()
            )
        );
    }
}
