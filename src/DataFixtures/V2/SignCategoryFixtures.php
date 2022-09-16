<?php

namespace App\DataFixtures\V2;

use App\Entity\SignCategory;
use App\Service\Fixtures\AppVersionFixturesGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class SignCategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $data = [
            'c1' => 'Signalétique interieure',
            'c2' => 'Cour des matériaux et Jardinerie',
        ];

        foreach ($data as $key => $label) {
            $category = new SignCategory();
            $category->setLabel($label);

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
