<?php

namespace App\DataFixtures\V1;

use App\Entity\Shop;
use App\Service\Fixture\CsvReader;
use App\Service\Fixtures\AppVersionFixturesGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ShopFixtures extends Fixture implements FixtureGroupInterface
{
    public const SHOP_NAME = 'shopName';
    private const ADDRESS = 'address';
    private const POSTAL_CODE = 'postalCode';
    private const CITY = 'city';
    private const REGION = 'region';

    public function __construct(
        private CsvReader $csvReader,
    ) {
    }

    public function load(ObjectManager $manager)
    {
        $data = $this->csvReader->getData(
            \dirname(__DIR__, 3) . '/resource/shop_listing_pw_encoded.csv',
            [
                self::SHOP_NAME,
                self::CITY,
                self::POSTAL_CODE,
                self::ADDRESS,
                self::REGION,
            ]
        );

        foreach ($data as $entry) {
            $shop = new Shop();

            $shop->setName($entry[self::SHOP_NAME]);
            $shop->setCity($entry[self::CITY]);
            $shop->setPostCode($this->getFormattedPostCode($entry[self::POSTAL_CODE]));
            $shop->setAddress($entry[self::ADDRESS]);
            $shop->setRegion($entry[self::REGION]);

            $manager->persist($shop);
            $this->setReference($entry[self::SHOP_NAME], $shop);
        }

        $manager->flush();
    }

    /**
     * @param string $data
     *
     * @return string
     */
    private function getFormattedPostCode(string $data): string
    {
        return (strlen($data) === 4 ) ? '0' . $data : $data;
    }

    public static function getGroups(): array
    {
        return [
            AppVersionFixturesGroup::V1,
        ];
    }
}
