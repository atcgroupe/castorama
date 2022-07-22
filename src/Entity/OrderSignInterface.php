<?php

namespace App\Entity;

interface OrderSignInterface
{
    public function getId(): ?int;

    public function getQuantity(): ?int;

    public function getOrder(): ?Order;
}
