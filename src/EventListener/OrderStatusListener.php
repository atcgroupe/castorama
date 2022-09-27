<?php

namespace App\EventListener;

use App\Service\Event\OrderEvent;
use App\Service\Notification\OrderEventNotificationDispatcher;
use App\Service\Order\OrderNotificationDispatcher;

class OrderStatusListener
{
    public function __construct(
        private readonly OrderEventNotificationDispatcher $orderNotificationDispatcher
    ) {
    }

    public function onOrderStatusChanged(OrderEvent $event)
    {
        if ($event->getOrder()->getStatus()->hasEvent()) {
            $this->orderNotificationDispatcher->dispatch($event->getOrder()->getId());
        }
    }
}
