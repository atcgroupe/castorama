<?php

namespace App\Entity;

use App\Repository\MaterialDirOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass=MaterialDirOrderSignRepository::class)
 */
class MaterialDirOrderSign extends AbstractVariableOrderSign
{
    private const TYPE = 'materialDir';
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

    public static function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return string
     *
     * @Groups({"api_xml_object"})
     */
    public function getSwitchTemplate(): string
    {
        return sprintf(
            '%s_%s_%s',
            $this->getSign()->getSwitchFlowTemplateFile(),
            $this->getTitle(),
            $this->getDirection()
        );
    }

    public function getFileName(): string
    {
        return sprintf(
            'COMMANDE %s PANNEAU DIRECTION EXTERIEUR ID%s %s %s %sEX.xml',
            $this->getOrderId(),
            $this->getId(),
            $this->getTitleLabel(),
            $this->getDirectionLabel(),
            $this->getQuantity()
        );
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
