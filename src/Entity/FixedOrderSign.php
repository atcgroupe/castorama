<?php

namespace App\Entity;

use App\Repository\FixedOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FixedOrderSignRepository::class)
 */
class FixedOrderSign extends AbstractOrderSign
{
    private const SIGN_TYPE = 'FIXED';

    /**
     * @ORM\ManyToOne(targetEntity=FixedSign::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fixedSign;

    public function getFixedSign(): ?FixedSign
    {
        return $this->fixedSign;
    }

    public function setFixedSign(?FixedSign $fixedSign): self
    {
        $this->fixedSign = $fixedSign;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return strtoupper(sprintf(
            'COMMANDE %s - %s %s ID%s %sEX.xml',
            $this->getOrderId(),
            $this->getFixedSign()->getCategoryLabel(),
            $this->getFixedSign()->getTitle(),
            $this->getId(),
            $this->getQuantity()
        ));
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
