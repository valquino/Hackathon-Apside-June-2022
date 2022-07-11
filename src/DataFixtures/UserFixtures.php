<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\AgencyFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($i = 0; $i < 20; $i++){
            $user = new User();
            $user->setEmail('user' . $i .'@gmail.com');
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setIsAvailable($faker->boolean());
            $user->setAgency($this->getReference('agency_' . rand(0, 24)));
            $user->addJob($this->getReference('job_' . rand(0, 8)));
            if ($i === 0) {
                $user->setRoles(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN', 'ROLE_USER']);
            } elseif ($i >= 1 && $i <= 5) {
                $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
            } else {
                $user->setRoles(['ROLE_USER']);
            }
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                'password'
            );
            $user->setPassword($hashedPassword);
            $user->addProject($this->getReference('project_' . rand(0, 40)));
            $user->addProject($this->getReference('project_' . rand(41, 60)));
            $user->addProject($this->getReference('project_' . rand(61, 80)));
            $user->addProject($this->getReference('project_' . rand(81, 95)));
            $user->addProject($this->getReference('project_' . rand(96, 149)));
            $i <= 5 ? $user->setIsAdmin(true) : $user->setIsAdmin(false);
            $user->addStack($this->getReference('stack_' . rand(0, 36)));
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            JobFixtures::class,
            ProjectFixtures::class,
            StackFixtures::class,
        ];
    }
}
