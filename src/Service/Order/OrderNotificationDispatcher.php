<?php

namespace App\Service\Order;

use App\Entity\Event;
use App\Entity\User;
use App\Repository\MemberRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class OrderNotificationDispatcher
{
    private const EMAIL_NOTIFICATIONS_ENABLED = 'enabled';
    private const EMAIL_NOTIFICATIONS_DISABLED = 'disabled';

    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly OrderSignResumeHelper $orderSignResumeHelper,
        private readonly MemberRepository $memberRepository,
        private readonly Environment $twig,
        private readonly MailerInterface $mailer,
        private readonly string $emailNotifications,
    ) {
    }

    /**
     * @param int $orderId
     * @return void
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError|NonUniqueResultException
     */
    public function send(int $orderId): void
    {
        if (!in_array(
            $this->emailNotifications, [self::EMAIL_NOTIFICATIONS_ENABLED, self::EMAIL_NOTIFICATIONS_DISABLED]
        )) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid env argument EMAIL_NOTIFICATIONS. Posible values are %s or %s',
                self::EMAIL_NOTIFICATIONS_ENABLED,
                self::EMAIL_NOTIFICATIONS_DISABLED
            ));
        }

        if ($this->emailNotifications === self::EMAIL_NOTIFICATIONS_DISABLED) {
            return;
        }

        $order = $this->orderRepository->findOneWithRelations($orderId);
        $resume = $this->orderSignResumeHelper->getResume($order);
        $addresses = $this->getMembersAddresses($order->getStatus()->getEvent(), $order->getUser());
        $content = $this->twig->render('email/order_notification.html.twig', ['order' => $order, 'resume' => $resume]);

        $email = (new Email())
            ->from(Address::create('Web2Print ATC Groupe <web2print@atc-groupe.com>'))
            ->to(...$addresses)
            ->subject('Notification de commande')
            ->html($content)
        ;

        $this->mailer->send($email);
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
