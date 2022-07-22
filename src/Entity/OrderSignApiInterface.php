<?php

namespace App\Entity;

interface OrderSignApiInterface
{
    /**
     * Used for Enfocus Switch API
     *
     * @return int
     */
    public function getOrderId(): int;

    /**
     * Returns the XML File name.
     *
     * @return string
     */
    public function getFileName(): string;

    /**
     * Returns the type of the sign (VARIABLE or FIXED)
     *
     * @return string
     */
    public function getSwitchSignType(): string;
}
