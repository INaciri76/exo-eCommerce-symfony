<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class ProductFixtures extends Fixture
{
    public function __construct(
        private SluggerInterface $slugger
    ) {}

    public function load(ObjectManager $manager): void
    {
        // use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create('fr_FR');

        for ($prod = 1; $prod <= 10; $prod++) {

            $product = new Product();
            $product->setName($faker->text(5));
            $product->setDescription($faker->text(200));
            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $product->setPrice($faker->numberBetween(900, 150000));
            $product->setStock($faker->numberBetween(0, 10));
            // Récupérer une catégorie existante via les références
            // cat-1, cat-2, cat-3… selon ce que tu as créé dans CategoryFixtures
            $category = $this->getReference('cat-' . rand(1, 3), Category::class); 
            $product->setCategory($category);
            $manager->persist($product);
            $this->addReference('prod-' .$prod, $product);
        }

        $manager->flush();
    }
}
