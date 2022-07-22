<?php

namespace App\Entity;

interface VariableOrderSignInterface
{
    /**
     * Returns the type of the sign (aisle, sector, ...)
     *
     * @return string
     */
    public static function getType(): string;
}
