<?php

namespace App\DataFixtures;


use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //Instanciation de Faker
        $faker = Factory::create('fr_FR');
        //Générer 50 produits
        for ($i = 0; $i<50;$i++){
            $product = new Product();
            $product
                ->setName($faker->sentence(3))
                ->setDescription($faker->optional()->realText())
                ->setPrice($faker->numberBetween(1000,35000))
                ->setCreatedAt($faker->dateTimeBetween('-6 month'))
                ;

            //récupération d'une category aléatoire par une référence
            $categoryReference='category '. $faker->NumberBetween(0,2);
            $category = $this->getReference($categoryReference);
            $product->setCategory($category);
            $manager->persist($product);
        }
        $manager->flush();
    }

    /**
     * liste des classes devant être chargées avant les fixtures
     */
    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}
