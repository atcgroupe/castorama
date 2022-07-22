<?php

namespace App\DataFixtures\V1;

use App\DataFixtures\AbstractSignFixtures;
use App\Entity\AbstractSign;
use App\Entity\AisleOrderSign;
use App\Entity\AisleSmallOrderSign;
use App\Entity\SectorOrderSign;
use App\Entity\Sign;
use App\Service\Fixtures\AppVersionFixturesGroup;

class SignFixtures extends AbstractSignFixtures
{
    /**
     * @return Sign[]
     */
    protected function getSignsData(): array
    {
        return [
            [
                self::ID => 1,
                self::CLASS_NAME => AisleOrderSign::class,
                self::TYPE => AisleOrderSign::getType(),
                self::IMAGE => 'aisle_order_sign.jpg',
                self::TITLE => 'Panneau allée avec pictogramme',
                self::DESCRIPTION => 'Format: 800x500mm<br>Impression: Recto/Verso<br>Finition: 2 Perfos hautes<br>Matière: PVC 5MM',
                self::WEIGHT => 0.50,
                self::BUILDER => 'AisleSignBuilder',
                self::TEMPLATE => 'AisleSignTemplate',
                self::PRICE => 14.50,
                self::CUSTOMER_REF => '178738',
                self::CATEGORY => AbstractSign::CATEGORY_INDOOR,
            ],
            [
                self::ID => 2,
                self::CLASS_NAME => AisleSmallOrderSign::class,
                self::TYPE => AisleSmallOrderSign::getType(),
                self::IMAGE => 'aisle_small_order_sign.jpg',
                self::TITLE => 'Panneau allée',
                self::DESCRIPTION => 'Format: 900x300mm<br>Impression: Recto/Verso<br>Finition: 2 Perfos hautes<br>Matière: PVC 5MM',
                self::WEIGHT => 0.40,
                self::BUILDER => 'AisleSmallSignBuilder',
                self::TEMPLATE => 'AisleSmallSignTemplate',
                self::PRICE => 10.50,
                self::CUSTOMER_REF => '178737',
                self::CATEGORY => AbstractSign::CATEGORY_INDOOR,
            ],
            [
                self::ID => 3,
                self::CLASS_NAME => SectorOrderSign::class,
                self::TYPE => SectorOrderSign::getType(),
                self::IMAGE => 'sector_order_sign.jpg',
                self::TITLE => 'Panneau secteur',
                self::DESCRIPTION => 'Format: 1600x500mm<br>Impression: Recto/Verso<br>Finition: 2 Perfos hautes<br>Matière: PVC 10MM',
                self::WEIGHT => 1.50,
                self::BUILDER => 'SectorSignBuilder',
                self::TEMPLATE => 'SectorSignTemplate',
                self::PRICE => 39.00,
                self::CUSTOMER_REF => '178736',
                self::CATEGORY => AbstractSign::CATEGORY_INDOOR,
            ],
        ];
    }

    public static function getGroups(): array
    {
        return [
            AppVersionFixturesGroup::V1,
        ];
    }
}
