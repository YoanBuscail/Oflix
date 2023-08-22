<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Créez des acteurs pour les films et séries

        // Acteurs d'Inception
        $actor1 = new Person();
        $actor1->setFirstname('Leonardo');
        $actor1->setLastname('DiCaprio');
        $manager->persist($actor1);

        $actor2 = new Person();
        $actor2->setFirstname('Joseph');
        $actor2->setLastname('Gordon-Levitt');
        $manager->persist($actor2);

        // Acteurs de La La Land
        $actor3 = new Person();
        $actor3->setFirstname('Ryan');
        $actor3->setLastname('Gosling');
        $manager->persist($actor3);

        $actor4 = new Person();
        $actor4->setFirstname('Emma');
        $actor4->setLastname('Stone');
        $manager->persist($actor4);

        // Acteurs de Breaking Bad (Série TV)
        $actor7 = new Person();
        $actor7->setFirstname('Bryan');
        $actor7->setLastname('Cranston');
        $manager->persist($actor7);

        $actor8 = new Person();
        $actor8->setFirstname('Aaron');
        $actor8->setLastname('Paul');
        $manager->persist($actor8);

        // Persistez les acteurs
        $manager->flush();
    }
}

