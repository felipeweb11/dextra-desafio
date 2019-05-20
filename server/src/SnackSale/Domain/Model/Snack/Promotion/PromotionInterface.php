<?php

namespace App\SnackSale\Domain\Model\Snack\Promotion;

use App\SnackSale\Domain\Model\Snack\SnackInterface;
use Money\Money;

interface PromotionInterface
{
    /**
     * Determine if promotion contemplates a specific snack
     *
     * @param SnackInterface $snack
     * @return bool
     */
    public function contemplates(SnackInterface $snack): bool;

    /**
     * Calculate discount amount for given snack based on original sale price
     *
     * @param SnackInterface $snack
     * @param Money $salePrice
     * @return Money
     */
    public function calcDiscount(SnackInterface $snack, Money $salePrice): Money;
}