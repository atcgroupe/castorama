<?php

namespace App\Service\Controller;

use App\Entity\User;
use App\Service\Alert\Alert;
use App\Service\Alert\HtmlAlert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractAppController extends AbstractController
{
    /**
     * @param string    $theme
     * @param string    $message
     * @param bool|null $autoHide
     * @param int|null  $delay
     */
    protected function dispatchAlert(
        string $theme,
        string $message,
        ?bool $autoHide = Alert::DEFAULT_AUTOHIDE,
        ?int $delay = Alert::DEFAULT_DELAY
    ) {
        $this->addFlash(Alert::FLASH_TYPE, new Alert($theme, $message, $autoHide, $delay));
    }

    /**
     * @param string    $theme
     * @param string    $message
     * @param bool|null $autoHide
     * @param int|null  $delay
     */
    protected function dispatchHtmlAlert(
        string $theme,
        string $message,
        ?bool $autoHide = Alert::DEFAULT_AUTOHIDE,
        ?int $delay = Alert::DEFAULT_DELAY
    ) {
        $this->addFlash(Alert::FLASH_TYPE, new HtmlAlert($theme, $message, $autoHide, $delay));
    }

    /**
     * @return bool
     */
    protected function isShopUser(): bool
    {
        return $this->isGranted(User::ROLE_CUSTOMER_SHOP);
    }

    /**
     * @return bool
     */
    protected function isCustomerUser(): bool
    {
        return
            $this->isGranted(User::ROLE_CUSTOMER_SHOP) ||
            $this->isGranted(User::ROLE_CUSTOMER_ADMIN)
        ;
    }
}
