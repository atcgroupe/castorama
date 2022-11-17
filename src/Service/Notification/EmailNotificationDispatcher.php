<?php

namespace App\Service\Notification;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailNotificationDispatcher
{
    private const ENABLED = 'enabled';
    private const DISABLED = 'disabled';

    public function __construct(
        private readonly string $emailNotifications,
        private readonly MailerInterface $mailer,
    ) {}

    /**
     * @param EmailNotification $notification
     * @return void
     * @throws TransportExceptionInterface
     */
    public function dispatch(EmailNotification $notification): void
    {
        if (!in_array(
            $this->emailNotifications, [self::ENABLED, self::DISABLED]
        )) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid env argument EMAIL_NOTIFICATIONS. Posible values are %s or %s',
                self::ENABLED,
                self::DISABLED
            ));
        }

        if ($this->emailNotifications === self::DISABLED) {
            return;
        }

        $email = (new Email())
            ->from($notification->getFrom())
            ->to(...$notification->getTo())
            ->subject($notification->getSubject())
            ->html($notification->getHtml())
        ;

        $this->mailer->send($email);
    }
}
