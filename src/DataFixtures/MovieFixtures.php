<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class MovieFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    $faker = Faker\Factory::create('fr_FR');

    for ($i=0; $i < 10; $i++) {
      $movie = new Movie();
      $movie->setTitle($faker->realText($maxNbChars = 50, $indexSize = 1));
      $movie->setSumary($faker->text($maxNbChars = 400));
      $movie->setReleaseYear(new \DateTime($faker->date($format = 'd-m-Y', $max = 'now')));
      $movie->setType("Horror");
      $movie->setAuthor($faker->firstNameMale() . " " . $faker->lastName());
      $manager->persist($movie);
    }
    $manager->flush();
  }
}
