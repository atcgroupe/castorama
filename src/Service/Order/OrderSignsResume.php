<?php

namespace App\Service\Order;

class OrderSignsResume
{
    private float $totalPrice = 0;
    private int $totalSignsCount = 0;

    public function __construct(
        private readonly array $signsResumes
    ) {
        $this->setTotals();
    }

    /**
     * @return OrderSignResume[]
     */
    public function getSignsResume(): array
    {
        return $this->signsResumes;
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    /**
     * @return int
     */
    public function getTotalSignsCount(): int
    {
        return $this->totalSignsCount;
    }

    /**
     * @return bool
     */
    public function hasMaterialDrillSign(): bool
    {
        foreach ($this->getSignsResume() as $resume) {
            if ($resume->customerReference === '181918') {
                return true;
            }
        }

        return false;
    }

    private function setTotals(): void
    {
        foreach ($this->getSignsResume() as $resume) {
            $this->totalPrice += $resume->totalPrice;
            $this->totalSignsCount += $resume->signsCount;
        }

        if ($this->totalPrice < 30) {
            $this->totalPrice = 30;
        }
    }
}
