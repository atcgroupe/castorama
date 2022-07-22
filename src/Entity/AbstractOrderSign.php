<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AbstractOrderSign implements OrderSignInterface, OrderSignApiInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"api_xml_object"})
     * @SerializedName("signId")
     */
    protected $id;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank
     * @Assert\Positive
     *
     * @Groups({"api_xml_object"})
     */
    protected $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class)
     * @ORM\JoinColumn(nullable=false)
     */
    protected $order;

    /**
     * Used for API json data
     *
     * @var string
     */
    protected string $data;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return int
     *
     * @Groups({"api_xml_object"})
     */
    public function getOrderId(): int
    {
        return $this->getOrder()->getId();
    }
}
