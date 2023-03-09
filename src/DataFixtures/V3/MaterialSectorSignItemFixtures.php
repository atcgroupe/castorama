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
            6 => "bordure",
            7 => "bordure & pilier",
            8 => "cloison & plafond",
            9 => "cloison & plancher",
            10 => "clotûre bois & panneaux",
            11 => "clotûre grillage",
            12 => "dalle & pavé",
            13 => "entretien du jardin",
            14 => "évacuation des eaux",
            15 => "isolation",
            16 => "jardin d'agrément",
            17 => "matériau de construction",
            18 => "matériel",
            19 => "menuiserie extérieure",
            20 => "menuiserie intérieure",
            21 => "muret",
            22 => "portail",
            23 => "tasseau & moulure",
            24 => "terrasse & sol extérieur",
            25 => "terrasse bois & composite",
            26 => "terreau",
            27 => "toiture",
            28 => "toiture charpente",
            29 => "toiture couverture"
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
