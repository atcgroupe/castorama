<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AbstractSign
{
    public const CATEGORY_INDOOR = 1;
    public const CATEGORY_OUTDOOR = 2;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2)
     */
    private $weight;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $customerReference;

    /**
     * @ORM\Column(type="smallint")
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getImagePath(): string
    {
        return 'build/images/sign/category/' . $this->getImage();
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCustomerReference(): ?string
    {
        return $this->customerReference;
    }

    public function setCustomerReference(string $customerReference): self
    {
        $this->customerReference = $customerReference;

        return $this;
    }

    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getCategoryLabel(): string
    {
        return match ($this->getCategory()) {
            self::CATEGORY_INDOOR => 'Signaletique interieure',
            self::CATEGORY_OUTDOOR => 'Cour des matériaux',
        };
    }

    public function setCategory($category): self
    {
        $this->category = $category;

        return $this;
    }
}
