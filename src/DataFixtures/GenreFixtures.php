<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $genre1 = new Genre;
        $genre1->setName('Science-Fiction');

        $genre2 = new Genre;
        $genre2->setName('Comédie Musicale');

        $manager->persist($genre1);
        $manager->persist($genre2);

        $manager->flush();
    }
}
