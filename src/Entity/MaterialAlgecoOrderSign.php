<?php

namespace App\Entity;

use App\Repository\MaterialAlgecoOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass=MaterialAlgecoOrderSignRepository::class)
 */
class MaterialAlgecoOrderSign extends AbstractVariableOrderSign
{
    private const TYPE = 'materialAlgeco';

    /**
     * @ORM\ManyToOne(targetEntity=MaterialAlgecoSignItem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $item1;

    /**
     * @ORM\ManyToOne(targetEntity=MaterialAlgecoSignItem::class)
     */
    private $item2;

    /**
     * @ORM\ManyToOne(targetEntity=MaterialAlgecoSignItem::class)
     */
    private $item3;

    /**
     * @ORM\ManyToOne(targetEntity=MaterialAlgecoSignItem::class)
     */
    private $item4;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem1(): ?MaterialAlgecoSignItem
    {
        return $this->item1;
    }

    public function setItem1(?MaterialAlgecoSignItem $item1): self
    {
        $this->item1 = $item1;

        return $this;
    }

    public function getItem2(): ?MaterialAlgecoSignItem
    {
        return $this->item2;
    }

    public function setItem2(?MaterialAlgecoSignItem $item2): self
    {
        $this->item2 = $item2;

        return $this;
    }

    public function getItem3(): ?MaterialAlgecoSignItem
    {
        return $this->item3;
    }

    public function setItem3(?MaterialAlgecoSignItem $item3): self
    {
        $this->item3 = $item3;

        return $this;
    }

    public function getItem4(): ?MaterialAlgecoSignItem
    {
        return $this->item4;
    }

    public function setItem4(?MaterialAlgecoSignItem $item4): self
    {
        $this->item4 = $item4;

        return $this;
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
            'COMMANDE %s PANNEAU ENTREE ALGECO ID%s %sEX.xml',
            $this->getOrderId(),
            $this->getId(),
            $this->getQuantity()
        );
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

    /**
     * @return string
     * @Groups({"api_json_data"})
     * @SerializedName("item4Label")
     */
    public function getItem4Label(): string
    {
        return (null === $this->getItem4()) ? '' : $this->getItem4()->getLabel();
    }
}
