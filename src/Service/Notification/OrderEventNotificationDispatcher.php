<?php

namespace App\Service\Notification;

use App\Entity\Event;
use App\Entity\User;
use App\Repository\MemberRepository;
use App\Repository\OrderRepository;
use App\Service\Order\OrderSignResumeHelper;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class OrderEventNotificationDispatcher
{
    public function __construct(
        private readonly EmailNotificationDispatcher $notificationDispatcher,
        private readonly OrderRepository $orderRepository,
        private readonly OrderSignResumeHelper $orderSignResumeHelper,
        private readonly MemberRepository $memberRepository,
        private readonly Environment $twig,
    ) {}

    /**
     * @param int $orderId
     * @return void
     * @throws NonUniqueResultException
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function dispatch(int $orderId): void
    {
        $order = $this->orderRepository->findOneWithRelations($orderId);
        $resume = $this->orderSignResumeHelper->getResume($order);
        $addresses = $this->getMembersAddresses($order->getStatus()->getEvent(), $order->getUser());
        $content = $this->twig->render('email/order_notification.html.twig', ['order' => $order, 'resume' => $resume]);
        $notification = new EmailNotification($addresses, 'Notification de commande', $content);

        $this->notificationDispatcher->dispatch($notification);
    }

    /**
     * Returns list of members emails who has subscribed to the event
     *
     * @param Event $event
     * @param User  $user
     *
     * @return array
     */
    private function getMembersAddresses(Event $event, User $user): array
    {
        $members = $this->memberRepository->findByEventAndUser($event, $user);

        $addresses = [];
        foreach ($members as $member) {
            $addresses[] = $member->getEmail();
        }

        return $addresses;
    }
}
