<?php

namespace App\DataFixtures\V3;

use App\Entity\MaterialSectorSignItem;
use App\Service\Fixtures\AppVersionFixturesGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class MaterialSectorSignItemFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $data = [
            1 => "assainissement évacuation",
            2 => "balustre & clautra",
            3 => "bardage couverture",
            4 => "béton mortier gros œuvre",
            5 => "bois & découpe",
            6 => "bordure & pilier",
            7 => "cloison & plafond",
            8 => "clotûre bois & panneaux",
            9 => "clotûre grillage",
            10 => "dalle & pavé",
            11 => "entretien du jardin",
            12 => "isolation",
            13 => "jardin d'agrément",
            14 => "matériau de construction",
            15 => "matériel",
            16 => "menuiserie extérieure",
            17 => "menuiserie intérieure",
            18 => "portail",
            19 => "tasseau & moulure",
            20 => "terrasse bois & composite",
            21 => "toiture",
            22 => "toiture charpente",
            23 => "toiture couverture"
        ];

        foreach ($data as $entry) {
            $item = new MaterialSectorSignItem();

            $item->setLabel($entry);
            $item->setIsActive(true);

            $manager->persist($item);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [
            AppVersionFixturesGroup::V3,
        ];
    }
}
