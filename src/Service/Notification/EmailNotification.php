<?php

namespace App\Service\Notification;

use Symfony\Component\Mime\Address;

class EmailNotification
{
    private Address $from;

    public function __construct(
        private readonly array  $to,
        private readonly string $subject,
        private readonly string $html,
    ) {
        $this->from = Address::create('Web2Print ATC Groupe <web2print@atc-groupe.com>');
    }

    /**
     * @return Address
     */
    public function getFrom(): Address
    {
        return $this->from;
    }

    /**
     * @return array
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }
}
