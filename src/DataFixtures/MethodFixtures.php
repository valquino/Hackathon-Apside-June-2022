<?php

namespace App\DataFixtures;

use App\Entity\Method;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MethodFixtures extends Fixture
{
    const METHODS = [
        'Agilité',
        'Scrum',
        'Cycle en V',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::METHODS as $key => $methodName) {
            $method = new Method;
            $method->setName($methodName);

            $manager->persist($method);
            $this->addReference('method_' . $key, $method);
        }

        $manager->flush();
    }
}
