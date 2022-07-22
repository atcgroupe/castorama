<?php

namespace App\Entity;

use App\Repository\SectorOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=SectorOrderSignRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class SectorOrderSign extends AbstractVariableOrderSign
{
    private const TYPE = 'sector';

    private $option;

    /**
     * @ORM\ManyToOne(targetEntity=SectorSignItem::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $item1;

    /**
     * @ORM\ManyToOne(targetEntity=SectorSignItem::class)
     */
    private $item2;

    /**
     * @ORM\PostLoad()
     */
    public function initializeOption()
    {
        $this->option = $this->getItem2() === null ? 1 : 2;
    }

    /**
     * @return mixed
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * @param mixed $option
     */
    public function setOption($option): void
    {
        $this->option = $option;
    }

    public function getItem1(): ?SectorSignItem
    {
        return $this->item1;
    }

    public function setItem1(?SectorSignItem $item1): self
    {
        $this->item1 = $item1;

        return $this;
    }

    public function getItem2(): ?SectorSignItem
    {
        return $this->item2;
    }

    public function setItem2(?SectorSignItem $item2): self
    {
        $this->item2 = $item2;

        return $this;
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->option === 2 && $this->item2 === null) {
            $context->buildViolation('Cette valeur ne doit pas être vide.')
                ->atPath('item2')
                ->addViolation();
        }
    }

    /**
     * @return string
     *
     * @Groups({"api_json_data"})
     * @SerializedName("item1Label")
     */
    public function getItem1Label(): string
    {
        return $this->getItem1()->getLabel();
    }

    /**
     * @return string
     *
     * @Groups({"api_json_data"})
     * @SerializedName("item1Color")
     */
    public function getItem1Color(): string
    {
        return $this->getItem1()->getColor();
    }

    /**
     * @return string
     *
     * @Groups({"api_json_data"})
     * @SerializedName("item2Label")
     */
    public function getItem2Label(): string
    {
        return (null === $this->getItem2()) ? $this->getItem1Label() : $this->getItem2()->getLabel();
    }

    /**
     * @return string
     *
     * @Groups({"api_json_data"})
     * @SerializedName("item2Color")
     */
    public function getItem2Color(): string
    {
        return (null === $this->getItem2()) ? $this->getItem1Color() : $this->getItem2()->getColor();
    }

    /**
     * Returns Enfocus Switch template
     *
     * @return string
     */
    public function getSwitchTemplate(): string
    {
        return sprintf(
            '%s_%s_%s',
            $this->getSign()->getSwitchFlowTemplateFile(),
            $this->getItem1Color(),
            $this->getItem2Color()
        );
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     */
    public function getFileName(): string
    {
        return sprintf(
            'COMMANDE %s PANNEAU SECTEUR %s %sEX.xml',
            $this->getOrderId(),
            $this->getId(),
            $this->getQuantity()
        );
    }
}
