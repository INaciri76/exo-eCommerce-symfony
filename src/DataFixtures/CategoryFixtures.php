<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private int $cptCat = 1;

    public function load(ObjectManager $manager): void
    {   
        // Liste des catégories à créer
        $categories = [
            'Informatique',
            'Ordinateur',
            'Téléphone',
        ];

        foreach ($categories as $catName) {

            $category = new Category();
            $category->setName($catName);

            $manager->persist($category);

            // Ajouter une référence utilisable dans ProductFixtures
            $this->addReference('cat-' . $this->cptCat, $category);

            $this->cptCat++;
        }

        $manager->flush();
    }
}
