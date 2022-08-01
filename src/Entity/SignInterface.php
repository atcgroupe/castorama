<?php

namespace App\Entity;

interface SignInterface
{
    /**
     * Sign description for choosing menu.
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Sign illustration for choosing menu.
     *
     * @return string
     */
    public function getChooseImagePath(): string;
}
