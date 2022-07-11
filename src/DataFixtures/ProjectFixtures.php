<?php

namespace App\DataFixtures;

use App\Entity\Project;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for($i = 0; $i < 150; $i++){
            $project = new Project();
            $project->setName('Projet_' . $i);
            $project->setCreatedAt(new DateTime());
            $project->setControlPoint($this->getReference('control_point_' . rand(0, 3)));
            $project->setMethod($this->getReference('method_' . rand(0, 2)));
            $project->setCustomer($this->getReference('customer_' . rand(0, 199)));
            $project->addCategory($this->getReference('category_' . rand(0, 25)));
            $project->addStack($this->getReference('stack_' . rand(0, 10)));
            $project->addStack($this->getReference('stack_' . rand(11, 20)));
            $project->addStack($this->getReference('stack_' . rand(21, 36)));
            $project->setAgency($this->getReference('agency_' . rand(0, 24)));
            $project->setDescription(implode(' ', $faker->words(60)));
            $project->setIsHidden($faker->boolean());
            $manager->persist($project);
            $this->addReference('project_' . $i, $project);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            MethodFixtures::class,
            ControlPointFixtures::class,
            CustomerFixtures::class,
            StackFixtures::class,
        ];
    }
}
