<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractVariableOrderSign extends AbstractOrderSign implements VariableOrderSignInterface, VariableOrderSignApiInterface
{
    private const SIGN_TYPE = 'VARIABLE';

    /**
     * @ORM\ManyToOne(targetEntity=Sign::class)
     * @ORM\JoinColumn(nullable=false)
     */
    protected $sign;

    public function getSign(): ?Sign
    {
        return $this->sign;
    }

    public function setSign(?Sign $sign): self
    {
        $this->sign = $sign;

        return $this;
    }

    /**
     * @return string
     *
     * @Groups({"api_xml_object"})
     */
    public function getSwitchBuilder(): string
    {
        return $this->getSign()->getSwitchFlowBuilder();
    }

    /**
     * @return string
     *
     * @Groups({"api_xml_object"})
     */
    public function getSwitchTemplate(): string
    {
        return $this->getSign()->getSwitchFlowTemplateFile();
    }

    /**
     * @return string
     *
     * @Groups({"api_xml_object"})
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData(string $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string
     *
     * @Groups({"api_xml_object"})
     */
    public function getSwitchSignType(): string
    {
        return self::SIGN_TYPE;
    }
}
