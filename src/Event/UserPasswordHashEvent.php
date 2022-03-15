<?php

namespace App\Event;

use App\Entity\Administrator;
use App\Entity\Author;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPasswordHashEvent
{
    private UserPasswordHasherInterface $encoder;

    /**
     * @param UserPasswordHasherInterface $encoder
     */
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function prePersist(LifecycleEventArgs $args): void{
        $entity = $args->getEntity();

        if(! ($entity instanceof Administrator || $entity instanceof  Author)){
            return;
        }

        $entity->setPassword($this->encoder->hashPassword(
            $entity, $entity->getPlainPassword()
        ));
    }

}