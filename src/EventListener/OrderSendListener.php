<?php

namespace App\EventListener;

use App\Entity\OrderStatus;
use App\Service\Event\OrderEvent;
use App\Service\Notification\OrderSentAmountAlertDispatcher;
use App\Service\Order\OrderHelper;

class OrderSendListener
{
    public function __construct(
        private readonly OrderHelper $orderHelper,
        private readonly OrderSentAmountAlertDispatcher $amountAlertDispatcher,
    ) {
    }

    public function onOrderSend(OrderEvent $event): void
    {
        $order = $event->getOrder();

        $this->orderHelper->setOrderStatus($order, OrderStatus::SENT);
        $order->setDeliveryDate($order->getCalculatedDeliveryDate());
        $this->amountAlertDispatcher->dispatch($order->getId());
    }
}
