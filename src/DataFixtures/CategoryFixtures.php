<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        // Creation enregistrement INFORMATIQUE 
            //créer un nouvel objet Category
            $category = new Category();

            //Nourrir l'objet
            $category->setName('Informatique');

            //Persister les données
            $manager->persist($category);
            
        //Creation enregistrement ORDINATEUR
            $category2= new Category();
            $category2->setName('Ordinateur');
            $manager->persist($category2);

        // $product = new Product();
        // $manager->persist($product);
        $manager->flush();
    }
}
