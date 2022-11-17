<?php

namespace App\DataFixtures\V2;

use App\Entity\MaterialServiceSignItem;
use App\Service\Fixtures\AppVersionFixturesGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class MaterialServiceSignItemFixtures extends Fixture implements FixtureGroupInterface
{
    private const LABEL = 'LABEL';
    private const COLOR = 'COLOR';

    public function load(ObjectManager $manager): void
    {
        $itemsData = [
            [self::LABEL => 'Avantage carte', self::COLOR => MaterialServiceSignItem::COLOR_BLUE],
            [self::LABEL => 'Livraison à domicile', self::COLOR => MaterialServiceSignItem::COLOR_YELLOW],
            [self::LABEL => 'Location de véhicule', self::COLOR => MaterialServiceSignItem::COLOR_YELLOW],
            [self::LABEL => 'Location de matériel', self::COLOR => MaterialServiceSignItem::COLOR_YELLOW],
            [self::LABEL => 'Installation à domicile', self::COLOR => MaterialServiceSignItem::COLOR_BLUE],
        ];

        foreach ($itemsData as $item) {
            $signItem = new MaterialServiceSignItem();
            $signItem->setLabel($item[self::LABEL]);
            $signItem->setColor($item[self::COLOR]);
            $signItem->setIsActive(true);

            $manager->persist($signItem);
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
