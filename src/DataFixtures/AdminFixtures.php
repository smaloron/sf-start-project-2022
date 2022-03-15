<?php

namespace App\DataFixtures;

use App\Entity\Administrator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{



    public function load(ObjectManager $manager ): void
    {
        $admin = new Administrator();
        $admin->setUsername('Joe admin');
        $admin->setPlainPassword('456');
        $manager->persist($admin);

        $admin = new Administrator();
        $admin->setUsername('Jane admin');
        $admin->setPlainPassword('456');
        $manager->persist($admin);

        $manager->flush();
    }
}
