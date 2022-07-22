<?php

namespace App\DataFixtures\V2;

use App\DataFixtures\AbstractSignFixtures;
use App\Entity\AbstractSign;
use App\Entity\MaterialAlgecoOrderSign;
use App\Entity\MaterialDirOrderSign;
use App\Entity\MaterialSectorOrderSign;
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
                self::ID => 4,
                self::CLASS_NAME => MaterialSectorOrderSign::class,
                self::TYPE => MaterialSectorOrderSign::getType(),
                self::IMAGE => 'material_sector_order_sign.jpg',
                self::TITLE => 'Panneau allée',
                self::DESCRIPTION => 'Format: 1050x1050mm<br>Impression: Recto<br>Matière: Dibond 3MM',
                self::WEIGHT => 4.20,
                self::BUILDER => 'MaterialSectorSignBuilder',
                self::TEMPLATE => 'MaterialSectorSignTemplate',
                self::PRICE => 40.00,
                self::CUSTOMER_REF => 'xxxxxx',
                self::CATEGORY => AbstractSign::CATEGORY_OUTDOOR,
            ],
            [
                self::ID => 5,
                self::CLASS_NAME => MaterialDirOrderSign::class,
                self::TYPE => MaterialDirOrderSign::getType(),
                self::IMAGE => 'material_dir_order_sign.jpg',
                self::TITLE => 'Panneau directionnel',
                self::DESCRIPTION => 'Format: 1050x1050mm<br>Impression: Recto<br>Matière: Dibond 3MM',
                self::WEIGHT => 4.20,
                self::BUILDER => 'MaterialDirSignBuilder',
                self::TEMPLATE => 'MaterialDirSignTemplate',
                self::PRICE => 40.00,
                self::CUSTOMER_REF => 'xxxxxx',
                self::CATEGORY => AbstractSign::CATEGORY_OUTDOOR,
            ],
            [
                self::ID => 6,
                self::CLASS_NAME => MaterialAlgecoOrderSign::class,
                self::TYPE => MaterialAlgecoOrderSign::getType(),
                self::IMAGE => 'material_algeco_order_sign.jpg',
                self::TITLE => 'Panneau entrée algeco',
                self::DESCRIPTION => 'Format: 500x700mm<br>Impression: Recto<br>Matière: Dibond 3MM',
                self::WEIGHT => 1.33,
                self::BUILDER => 'MaterialAlgecoSignBuilder',
                self::TEMPLATE => 'MaterialAlgecoSignTemplate',
                self::PRICE => 40.00,
                self::CUSTOMER_REF => 'xxxxxx',
                self::CATEGORY => AbstractSign::CATEGORY_OUTDOOR,
            ],
        ];
    }

    public static function getGroups(): array
    {
        return [
            AppVersionFixturesGroup::V2,
        ];
    }
}
