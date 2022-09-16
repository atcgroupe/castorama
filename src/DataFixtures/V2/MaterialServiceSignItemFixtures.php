<?php

namespace App\DataFixtures\V2;

use App\Entity\MaterialServiceSignItem;
use App\Service\Fixtures\AppVersionFixturesGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class MaterialServiceSignItemFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $itemsData = [
            'Avantage carte',
            'Livraison à domicile',
            'Location de véhicule',
            'Location de matériel',
            'Installation à domicile'
        ];

        foreach ($itemsData as $label) {
            $item = new MaterialServiceSignItem();
            $item->setLabel($label);
            $item->setIsActive(true);

            $manager->persist($item);
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
