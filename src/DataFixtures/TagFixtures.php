<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends Fixture implements OrderedFixtureInterface
{
    public static int $numberOfRecords;

    public static array $tags = [
        "PHP", "Java", "Symfony", "MySQL", "Python",
        "Judo", "Natation", "Escalade", "Footing", "Yoga",
        "Vacances", "Loisirs", "Lectures", "Conso",
    ];

    public function __construct()
    {
        self::$numberOfRecords = count(self::$tags);
    }


    public function load(ObjectManager $manager): void
    {
        for($i=0; $i < self::$numberOfRecords; $i ++){
            $tag = new Tag();
            $tag->setTagName(self::$tags[$i]);
            $this->addReference("tag".($i+1), $tag);

            $manager->persist($tag);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 5;
    }
}
