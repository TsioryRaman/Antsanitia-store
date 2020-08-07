<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create("fr_FR");
        for ($i=0;$i<100;$i++)
        {
            $product = new Product();
            $product->setName($faker->words(3,true));
            $product->setPrice($faker->numberBetween(10000,10000000));
            $product->setDescription($faker->sentence());
            $manager->persist($product);
        }
        $manager->flush();
    }
}
