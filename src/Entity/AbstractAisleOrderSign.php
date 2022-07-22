<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractAisleOrderSign extends AbstractVariableOrderSign
{
    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank
     * @Assert\Positive
     * @Groups({"api_json_data"})
     */
    protected $aisleNumber;

    /**
     * @ORM\ManyToOne(targetEntity=AisleSignItem::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Merci de sélectionner au moins un produit.")
     */
    protected $item1;

    /**
     * @ORM\ManyToOne(targetEntity=AisleSignItem::class)
     */
    protected $item2;

    /**
     * @ORM\ManyToOne(targetEntity=AisleSignItem::class)
     */
    protected $item3;

    protected $category;

    public function getAisleNumber(): ?int
    {
        return $this->aisleNumber;
    }

    public function setAisleNumber(int $aisleNumber): self
    {
        $this->aisleNumber = $aisleNumber;

        return $this;
    }

    public function getItem1(): ?AisleSignItem
    {
        return $this->item1;
    }

    public function setItem1(?AisleSignItem $item1): self
    {
        $this->item1 = $item1;

        return $this;
    }

    public function getItem2(): ?AisleSignItem
    {
        return $this->item2;
    }

    public function setItem2(?AisleSignItem $item2): self
    {
        $this->item2 = $item2;

        return $this;
    }

    public function getItem3(): ?AisleSignItem
    {
        return $this->item3;
    }

    public function setItem3(?AisleSignItem $item3): self
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
     * @return AisleSignItemCategory|null
     */
    public function getCategory(): ?AisleSignItemCategory
    {
        return $this->category;
    }

    /**
     * @param AisleSignItemCategory|null $category
     */
    public function setCategory(?AisleSignItemCategory $category): void
    {
        $this->category = $category;
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
}
