<?php

namespace App\Entity;

interface VariableOrderSignApiInterface
{
    /**
     * Returns the Callas builder name that is used to apply content on pdf file.
     *
     * @return string
     */
    public function getSwitchBuilder(): string;

    /**
     * Returns the Callas pdf template name that is used to generate production file.
     *
     * Note: the name is returned without file extension.
     *
     * @return string
     */
    public function getSwitchTemplate(): string;

    /**
     * Used for Enfocus Switch API
     *
     * @return string
     */
    public function getData(): string;
}
