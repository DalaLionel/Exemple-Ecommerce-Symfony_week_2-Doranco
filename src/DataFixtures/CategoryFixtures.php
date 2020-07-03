<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       //instanciation de Faker
        $faker = Factory::create('fe_FR');

        //Création de 3 catégories de produits
        for($i=0;$i<3;$i++)
        {
            $category = new Category();
            $category->setName($faker->realText(15));
            $manager->persist($category);
            //définir une référence sur l'entité, pour la récupérer dans d'autres fixtures
            $reference = 'category '.$i;
            $this->addReference($reference, $category);
        }

        $manager->flush();
    }

}
