<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UserFixtures extends Fixture
{
    
    public function __construct( 
        private UserPasswordHasherInterface $userPasswordHasher,
        private SluggerInterface $slugger
    
    ){}

        
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@demo.fr');
        $admin->setLastname('Tigre');
        $admin->setFirstname('Tigrou');
        $admin->setAddress('15 rue de la jungle du sanglier');
        $admin->setZipcode('76000');
        $admin->setCity('Rouen');
        $admin->setPassword(
            $this->userPasswordHasher->hashPassword($admin, 'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Faker\Factory::create('fr_FR');

        for($usr = 1; $usr <=5; $usr++){

        $user = new User();
        $user->setEmail($faker->email);
        $user->setLastname($faker->lastName);
        $user->setFirstname($faker->firstName);
        $user->setAddress($faker->streetAddress);
        $user->setZipcode($faker->postcode);
        $user->setCity($faker->city);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword($user, 'secret')
        );

        $manager->persist($user);
        }

        $manager->flush();
    }
}
