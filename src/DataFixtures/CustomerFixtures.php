<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CustomerFixtures extends Fixture
{
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i < 200; $i++) { 
            $customer = new Customer;
            $customer->setCompanyName($faker->company());
            $customer->setReferentName($faker->firstName() . ' ' . $faker->lastName());
            $customer->setEmail($faker->companyEmail());
            $customer->setPhoneNumber($faker->phoneNumber());
            $customer->setLogo('https://picsum.photos/' . rand(250, 300) . '/' . rand(250, 300));

            $manager->persist($customer);
            $this->addReference('customer_' . $i, $customer);
        }

        $manager->flush();
    }
}
