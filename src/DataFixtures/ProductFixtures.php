<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName("Clavier")
                ->setPrice(6)
                ->setCategory("input");
        $manager->persist($product);

        $product = new Product();
        $product->setName("Disque dur")
            ->setPrice(6)
            ->setCategory("storage");
        $manager->persist($product);

        $product = new Product();
        $product->setName("Imprimante laser")
            ->setPrice(6)
            ->setCategory("output");
        $manager->persist($product);



        $manager->flush();
    }
}
