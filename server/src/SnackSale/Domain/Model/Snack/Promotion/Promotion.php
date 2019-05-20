<?php

namespace App\SnackSale\Domain\Model\Snack\Promotion;

use App\SnackSale\Domain\Model\Entity;
use App\SnackSale\Domain\Model\Snack\Promotion\Types\CombineAndPayLessPromotion;
use App\SnackSale\Domain\Model\Snack\Promotion\Types\TakeMorePayLessPromotion;

abstract class Promotion extends Entity
{
    private $name;
    private $type;

    public function __construct(string $name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public static function createCombineAndPayLessPromotion(string $name): CombineAndPayLessPromotion
    {
        return new CombineAndPayLessPromotion($name, PromotionType::COMBINE_AND_PAY_LESS);
    }

    public static function createTakeMorePayLessPromotion(string $name): TakeMorePayLessPromotion
    {
        return new TakeMorePayLessPromotion($name, PromotionType::TAKE_MORE_PAY_LESS);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'type' => $this->getType()
        ];
    }
}