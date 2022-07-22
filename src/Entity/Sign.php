<?php

namespace App\Entity;

use App\Repository\SignRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SignRepository::class)
 */
class Sign extends AbstractSign
{
    /**
     * @ORM\Column(type="string", length=150)
     */
    private $class;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $switchFlowBuilder;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $SwitchFlowTemplateFile;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $type;

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getSwitchFlowBuilder(): ?string
    {
        return $this->switchFlowBuilder;
    }

    public function setSwitchFlowBuilder(string $switchFlowBuilder): self
    {
        $this->switchFlowBuilder = $switchFlowBuilder;

        return $this;
    }

    public function getSwitchFlowTemplateFile(): ?string
    {
        return $this->SwitchFlowTemplateFile;
    }

    public function setSwitchFlowTemplateFile(string $SwitchFlowTemplateFile): self
    {
        $this->SwitchFlowTemplateFile = $SwitchFlowTemplateFile;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreateRoute(): string
    {
        return sprintf('order_sign_%s_create', $this->type);
    }

    /**
     * @return string
     */
    public function getTypeLabel(): string
    {
        return sprintf('%s - %s', $this->getCategoryLabel(), $this->getTitle());
    }
}
