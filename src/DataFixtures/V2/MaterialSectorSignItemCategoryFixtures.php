<?php

namespace App\DataFixtures\V2;

use App\Entity\MaterialSectorSignItemCategory;
use App\Service\Fixtures\AppVersionFixturesGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class MaterialSectorSignItemCategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $categories = [
            1 => 'aménagement',
            2 => 'cloison et plafond',
            3 => 'clôture',
            4 => 'entretien jardin',
            5 => 'évacuation',
            6 => 'isolation',
            7 => 'matériau',
            8 => 'matériel',
            9 => 'portail',
            10 => 'poudre',
            11 => 'sol extérieur',
            12 => 'toiture',
            13 => 'jardin extérieur',
            14 => 'entretien du jardin',
            15 => 'jardin d\'agrément',
        ];

        foreach ($categories as $key => $label) {
            $category = new MaterialSectorSignItemCategory();
            $category->setLabel($label);
            $category->setIsActive(true);

            $manager->persist($category);
            $this->setReference($key, $category);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [
            AppVersionFixturesGroup::V2,
        ];
    }
}
