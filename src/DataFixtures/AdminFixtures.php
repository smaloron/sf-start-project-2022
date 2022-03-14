<?php

namespace App\DataFixtures;

use App\Entity\Administrator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;

    /**
     * @param UserPasswordHasherInterface $encoder
     */
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager ): void
    {
        $admin = new Administrator();
        $admin->setUsername('Joe admin');
        $admin->setPassword($this->encoder->hashPassword(
            $admin, '456'
        ));
        $manager->persist($admin);

        $admin = new Administrator();
        $admin->setUsername('Jane admin');
        $admin->setPassword($this->encoder->hashPassword(
            $admin, '456'
        ));
        $manager->persist($admin);

        $manager->flush();
    }
}
