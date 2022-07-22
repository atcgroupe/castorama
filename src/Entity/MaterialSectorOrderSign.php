<?php

namespace App\Entity;

use App\Repository\MaterialSectorOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MaterialSectorOrderSignRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"order", "aisleNumber", "alignment"},
 *     errorPath="aisleNumber",
 *     message="Un panneau allée avec ce numéro et cet alignement existe déjà dans cette commande"
 * )
 */
class MaterialSectorOrderSign extends AbstractVariableOrderSign
{
    private const TYPE = 'materialSector';

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
     * @Assert\NotBlank(message="Vous devez sélectionner au moins un produit.")
     */
    private $item1;

    /**
     * @ORM\ManyToOne(targetEntity=MaterialSectorSignItem::class)
     */
    private $item2;

    /**
     * @ORM\ManyToOne(targetEntity=MaterialSectorSignItem::class)
     */
    private $item3;

    /**
     * @Assert\NotBlank(message="Vous devez sélectionner la catégorie.")
     */
    private $category;

    public function getAisleNumber(): ?int
    {
        return $this->aisleNumber;
    }

    public function setAisleNumber(int $aisleNumber): self
    {
        $this->aisleNumber = $aisleNumber;

        return $this;
    }

    public function getAlignment(): ?string
    {
        return $this->alignment;
    }

    public function setAlignment(string $alignment): self
    {
        $this->alignment = $alignment;

        return $this;
    }

    public function getItem1(): ?MaterialSectorSignItem
    {
        return $this->item1;
    }

    public function setItem1(?MaterialSectorSignItem $item1): self
    {
        $this->item1 = $item1;

        return $this;
    }

    public function getItem2(): ?MaterialSectorSignItem
    {
        return $this->item2;
    }

    public function setItem2(?MaterialSectorSignItem $item2): self
    {
        $this->item2 = $item2;

        return $this;
    }

    public function getItem3(): ?MaterialSectorSignItem
    {
        return $this->item3;
    }

    public function setItem3(?MaterialSectorSignItem $item3): self
    {
        $this->item3 = $item3;

        return $this;
    }

    /**
     * @ORM\PostLoad()
     */
    public function initializeCategory()
    {
        $this->setCategory(($this->getItem1() !== null) ? $this->getItem1()->getCategory() : null);
    }

    /**
     * @return MaterialSectorSignItemCategory|null
     */
    public function getCategory(): ?MaterialSectorSignItemCategory
    {
        return $this->category;
    }

    /**
     * @param MaterialSectorSignItemCategory|null $category
     */
    public function setCategory(?MaterialSectorSignItemCategory $category): void
    {
        $this->category = $category;
    }

    public static function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     */
    public function getFileName(): string
    {
        return sprintf(
            'COMMANDE %s PANNEAU ALLEE EXTERIEUR %s %s %sEX.xml',
            $this->getOrderId(),
            $this->getAisleNumber(),
            $this->getAlignmentLabel(),
            $this->getQuantity()
        );
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     * @SerializedName("sectorLabel")
     */
    public function getSectorLabel(): string
    {
        return (null === $this->getCategory()) ? '' : $this->getCategory()->getLabel();
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     * @SerializedName("item1Label")
     */
    public function getItem1Label(): string
    {
        return (null === $this->getItem1()) ? '' : $this->getItem1()->getLabel();
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     * @SerializedName("item2Label")
     */
    public function getItem2Label(): string
    {
        return (null === $this->getItem2()) ? '' : $this->getItem2()->getLabel();
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     * @SerializedName("item3Label")
     */
    public function getItem3Label(): string
    {
        return (null === $this->getItem3()) ? '' : $this->getItem3()->getLabel();
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
