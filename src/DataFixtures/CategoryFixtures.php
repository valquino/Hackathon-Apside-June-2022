<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
        'Télécoms',
        'Énergie',
        'Industries lourdes',
        'R&D',
        'Agroalimentaire',
        'Industrie pharmaceutique',
        'Médecine',
        'Transport de personnes',
        'Transport de marchandises',
        'Logistique',
        'Ingénierie',
        'Commerce',
        'Distribution',
        'Chimie',
        'Édition',
        'Communication',
        'Électronique',
        'Électricité',
        'Informatique',
        'BTP',
        'Machines et équipements',
        'Automobile',
        'Métallurgie',
        'Plastique',
        'Services aux entreprises',
        'Textile / Habillement / Chaussures',

    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new Category;
            $category->setName($categoryName);

            $manager->persist($category);
            $this->addReference('category_' . $key, $category);
        }

        $manager->flush();
    }
}
