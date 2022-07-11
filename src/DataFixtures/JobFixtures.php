<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class JobFixtures extends Fixture
{
    const JOBS = [
        'Développeur Back-End',
        'Développeur Front-End',
        'Développeur Full-Stack',
        'Data engineer',
        'Data analyst',
        'Product Owner',
        'Scrum Master',
        'Chef de projet',
        'Dev Ops',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::JOBS as $key => $jobName) {
            $job = new Job;
            $job->setName($jobName);

            $manager->persist($job);
            $this->addReference('job_' . $key, $job);
        }

        $manager->flush();
    }
}
