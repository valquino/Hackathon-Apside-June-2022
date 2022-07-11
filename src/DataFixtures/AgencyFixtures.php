<?php

namespace App\DataFixtures;

use App\Entity\Agency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AgencyFixtures extends Fixture
{
    const AGENCIES =[
        'Toulouse',
        'Orléans',
        'Lille',
        'Bordeaux',
        'Rennes',
        'Dijon',
        'Nice - Sophia Antipolis',
        'Le Mans',
        'Aix-en-Provence',
        'Nantes',
        'Montpellier',
        'Niort',
        'Lyon',
        'Vernont',
        'Clermont-Ferrand',
        'Brest',
        'Tours',
        'Strasbourg',
        'Paris',
        'Allemangne',
        'Belgique',
        'Maroc',
        'Portugal',
        'Suisse',
        'Canada'
    ];

    public function load(ObjectManager $manager): void
    {

        for ($i=0; $i < count(self::AGENCIES); $i++) { 
            $agency = new Agency;
            $agency->setName(self::AGENCIES[$i]);
            $manager->persist($agency);
            $this->addReference('agency_' . $i, $agency);
        }
        $manager->flush();
    }
}
