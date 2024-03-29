<?php

namespace App\Entity;

use App\Repository\MaterialDirOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MaterialDirOrderSignRepository::class)
 * @UniqueEntity(
 *     fields={"order", "title", "direction"},
 *     errorPath="direction",
 *     message="Un panneau identique existe déjà dans cette commande"
 * )
 */
class MaterialDirOrderSign extends AbstractOrderSign
{
    public const TITLE_CAISSE = 'c';
    public const TITLE_SORTIE = 's';
    public const TITLE_CAISSE_SORTIE = 'cs';
    public const DIR_LEFT = 'left';
    public const DIR_RIGHT = 'right';
    public const DIR_TOP = 'top';

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $direction;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(string $direction): self
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * @return string
     *
     * @Groups({"api_xml_object"})
     */
    public function getTemplateFilename(): string
    {
        return sprintf(
            '%s_%s_%s',
            $this->getSign()->getName(),
            $this->getTitle(),
            $this->getDirection()
        );
    }

    /**
     * @return string
     */
    public function getXmlFilename(): string
    {
        return $this->getFormattedXmlFilename($this->getTitleLabel() . ' ' . $this->getDirectionLabel());
    }

    /**
     * @return string|null
     */
    private function getTitleLabel(): string|null
    {
        return match ($this->getTitle()) {
            self::TITLE_CAISSE => 'CAISSE',
            self::TITLE_SORTIE => 'SORTIE',
            self::TITLE_CAISSE_SORTIE => 'CAISSE SORTIE',
            default => ''
        };
    }

    /**
     * @return string|null
     */
    private function getDirectionLabel(): string|null
    {
        return match ($this->getDirection()) {
            self::DIR_LEFT => 'GAUCHE',
            self::DIR_RIGHT => 'DROITE',
            self::DIR_TOP => 'FACE',
            default => ''
        };
    }
}
