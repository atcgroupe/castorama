<?php

namespace App\Service\Order;

use App\Entity\AbstractOrderSign;
use App\Entity\MaterialSectorOrderSign;
use App\Entity\Order;
use App\Entity\Sign;
use Doctrine\ORM\EntityManagerInterface;

class OrderSignHelper
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {
    }

    /**
     * @param Order $order
     *
     * @return array
     */
    public function findOrderSigns(Order $order): array
    {
        $signs = [];
        foreach ($this->getSignsTypes() as $type) {
            $elements = $this->manager->getRepository($type->getClass())->findByOrderWithRelations($order);
            if (!empty($elements)) {
                $signs[$type->getTypeLabel()] = $elements;
            }
        }

        return $signs;
    }

    /**
     * Saves new sign in the database.
     *
     * This method has been added because
     * if the sign entity is an instance of MaterialSectorOrderSign and alignment attribute is set to "all",
     * The sign is duplicated and two entities are saved in the database:
     * one with "left" alignment and one with "right" alignment
     *
     * @param AbstractOrderSign $sign
     * @return void
     */
    public function createOrderSign(AbstractOrderSign $sign): void
    {
        if (
            $sign::class === MaterialSectorOrderSign::class &&
            $sign->getAlignment() === MaterialSectorOrderSign::ALIGN_ALL
        ) {
            $leftSign = $sign->setAlignment(MaterialSectorOrderSign::ALIGN_LEFT);
            $rightSign = clone $leftSign;
            $rightSign->setAlignment(MaterialSectorOrderSign::ALIGN_RIGHT);

            $this->manager->persist($leftSign);
            $this->manager->persist($rightSign);

            $this->manager->flush();

            return;
        }

        $this->manager->persist($sign);
        $this->manager->flush();
    }

    public function deleteOrderSigns(Order $order): void
    {
        $signTypes = $this->getSignsTypes();

        foreach ($signTypes as $type) {
            $this->manager->getRepository($type->getClass())->removeByOrder($order);
        }
    }

    /**
     * @param Order $order
     *
     * @return array|null
     */
    public function getOrderSignsResume(Order $order): array | null
    {
        $signResume = [];
        $totalPrice = 0;
        $totalCount = 0;

        foreach ($this->getSignsTypes() as $type) {
            $repository = $this->manager->getRepository($type->getClass());
            $count = $this->countSigns($repository->findBy(['order' => $order]));
            $countModels = $repository->count(['order' => $order]);
            $price = $type->getPrice();
            $countPrice = $count * $price;
            $totalCount += $count;
            $totalPrice += $countPrice;
            if ($count > 0) {
                $signResume[$type->getTitle()] = [
                    'category' => $type->getCategoryLabel(),
                    'customerReference' => $type->getCustomerReference(),
                    'count' => $count,
                    'countModels' => $countModels,
                    'unitPrice' => $type->getPrice(),
                    'countPrice' => $type->getPrice() * $count,
                ];
            }
        }

        $resume = [
            'global' => [
                'count' => $totalCount,
                'price' => ($totalPrice > 30) ? $totalPrice : 30.00,
            ],
            'sign' => $signResume
        ];

        return ($totalCount > 0 ) ? $resume : null;
    }

    /**
     * @return Sign[]
     */
    private function getSignsTypes(): array
    {
        return $this->manager->getRepository(Sign::class)->findAll();
    }

    /**
     * @param AbstractOrderSign[] $signs
     */
    private function countSigns(array $signs)
    {
        $count = 0;
        foreach ($signs as $sign) {
            $count += $sign->getQuantity();
        }

        return $count;
    }
}
