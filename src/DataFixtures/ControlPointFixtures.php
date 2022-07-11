<?php

namespace App\DataFixtures;

use App\Entity\ControlPoint;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ControlPointFixtures extends Fixture
{
    const CONTROL_POINTS = [
        'Lancement',
        'Planification',
        'Mise en œuvre',
        'Clôturé',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CONTROL_POINTS as $key => $controlPointName) {
            $controlPoint = new ControlPoint;
            $controlPoint->setName($controlPointName);

            $manager->persist($controlPoint);
            $this->addReference('control_point_' . $key, $controlPoint);
        }

        $manager->flush();
    }
}
