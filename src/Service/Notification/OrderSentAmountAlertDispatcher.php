<?php

namespace App\Service\Notification;

use App\Repository\MemberRepository;
use App\Repository\OrderRepository;
use App\Service\Order\OrderSignResumeHelper;
use Twig\Environment;

class OrderSentAmountAlertDispatcher
{
    public function __construct(
        private readonly EmailNotificationDispatcher $notificationDispatcher,
        private readonly OrderRepository $orderRepository,
        private readonly MemberRepository $memberRepository,
        private readonly OrderSignResumeHelper $orderSignResumeHelper,
        private readonly Environment $twig,
    ) {}

    public function dispatch(int $orderId)
    {
        $order = $this->orderRepository->findOneWithRelations($orderId);
        $resume = $this->orderSignResumeHelper->getResume($order);
        $addresses = $this->getMemberAddresses($resume->getTotalPrice());
        $content = $this->twig->render(
            'email/order_amount_alert_notification.html.twig',
            [
                'order' => $order,
                'resume' => $resume
            ]
        );

        if (!empty($addresses)) {
            $notification = new EmailNotification($addresses, 'Alerte sur le montant d\'une commande', $content);
            $this->notificationDispatcher->dispatch($notification);
        }
    }

    /**
     * @param float $totalPrice
     * @return array
     */
    private function getMemberAddresses(float $totalPrice): array
    {
        $members = $this->memberRepository->findAll();
        $addresses = [];
        foreach ($members as $member) {
            if ($member->getAmountAlert() && $totalPrice > $member->getAmountLevel()) {
                $addresses[] = $member->getEmail();
            }
        }

        return $addresses;
    }
}
