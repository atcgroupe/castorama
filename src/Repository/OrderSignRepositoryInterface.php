<?php

namespace App\Repository;

use App\Entity\AbstractOrderSign;
use App\Entity\Order;

interface OrderSignRepositoryInterface
{
    /**
     * @param Order $order
     *
     * @return AbstractOrderSign[]
     */
    public function findByOrderWithRelations(Order $order): array;

    /**
     * @param Order $order
     */
    public function removeByOrder(Order $order): void;
}
