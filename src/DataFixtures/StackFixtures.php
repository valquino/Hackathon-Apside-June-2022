<?php

namespace App\DataFixtures;

use App\Entity\Stack;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\ProjectFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class StackFixtures extends Fixture
{
    const STACKS = [
        'HTML',
        'CSS',
        'Sass',
        'SCSS',
        'Php',
        'JavaScript',
        'TypeScript',
        'Ruby',
        'Java',
        'Python',
        'Kotlin',
        'Go',
        'Swift',
        'C',
        'C++',
        'Symfony',
        'Laravel',
        'React.js',
        'Vue.js',
        'AngularJS',
        'Node.js',
        'Rails',
        'Spring',
        'Django',
        'PyTorch',
        'Flutter',
        'Linux',
        'Windows',
        'Mac OS',
        'Apache',
        'NGinx',
        'MySQL',
        'PostgreSQL',
        'MongoDB',
        'AWS',
        'Azure',
        'Google Cloud',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::STACKS as $key => $stackName) {
            $stack = new Stack;
            $stack->setName($stackName);

            $manager->persist($stack);
            $this->addReference('stack_' . $key, $stack);
        }

        $manager->flush();
    }
}
