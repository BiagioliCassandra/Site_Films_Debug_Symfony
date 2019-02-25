<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures
{
  private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $paswordEncoder;
     }

    public function load(ObjectManager $manager)
    {
      $faker = Faker\Factory::create('fr_FR');
      for ($i=0; $i < 10; $i++) {
        $user = new User();
        $user->setUsername($faker->lastName());
        $user->setPassword("password$i");
      }
        $manager->flush();
    }
}
