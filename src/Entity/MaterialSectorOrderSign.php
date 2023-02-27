<?php

namespace App\Entity;

use App\Repository\MaterialSectorOrderSignRepository;
use App\Service\String\Formatter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MaterialSectorOrderSignRepository::class)
 * @UniqueEntity(
 *     fields={"order", "aisleNumber", "alignment"},
 *     errorPath="aisleNumber",
 *     message="Un panneau allée avec ce numéro et cet alignement existe déjà dans cette commande"
 * )
 */
class MaterialSectorOrderSign extends AbstractVariableOrderSign
{
    public const ALIGN_LEFT = 'left';
    public const ALIGN_RIGHT = 'right';
    public const ALIGN_ALL = 'all'; // Used in form to create 2 signs (one left + one right)

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"api_json_data"})
     */
    private $aisleNumber;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"api_json_data"})
     */
    private $alignment;

    /**
     * @ORM\ManyToOne(targetEntity=MaterialSectorSignItem::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Vous devez sélectionner un secteur")
     */
    private $sector;

    public function getAisleNumber(): ?int
    {
        return $this->aisleNumber;
    }

    public function setAisleNumber(int $aisleNumber): self
    {
        $this->aisleNumber = $aisleNumber;

        return $this;
    }

    /**
     * @return string|null
     * @Groups({"api_json_data"})
     * @SerializedName("alignment")
     */
    public function getAlignment(): ?string
    {
        return $this->alignment;
    }

    public function setAlignment(string $alignment): self
    {
        $this->alignment = $alignment;

        return $this;
    }

    public function getSector(): ?MaterialSectorSignItem
    {
        return $this->sector;
    }

    public function setSector(?MaterialSectorSignItem $sector): self
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * @return string
     */
    public function getXmlFilename(): string
    {
        return $this->getFormattedXmlFilename($this->getAisleNumber() . ' ' . $this->getAlignmentLabel());
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     * @SerializedName("sectorLabel")
     */
    public function getSectorLabel(): string
    {
        return $this->getSector()->getLabel();
    }

    /**
     * @return bool
     * @Groups({"api_json_data"})
     */
    public function isSectorLabelStretch(): bool
    {
        $words = explode(" ", $this->getSectorLabel());
        $isStretch = false;

        foreach ($words as $word) {
            if ($word > 13) {
                $isStretch = true;
            }
        }

        return $isStretch;
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     * @SerializedName("productTextClass")
     */
    public function getProductTextClass(): string
    {
        return ($this->isSectorLabelStretch()) ? 'stretch' : 'normal';
    }

    private function getAlignmentLabel(): string
    {
        return match ($this->getAlignment()) {
            self::ALIGN_LEFT => 'GAUCHE',
            self::ALIGN_RIGHT => 'DROITE',
            default => ''
        };
    }
}
