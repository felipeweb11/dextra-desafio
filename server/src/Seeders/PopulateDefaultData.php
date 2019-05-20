<?php

namespace App\Seeders;

use App\SnackSale\Domain\Model\Customer\Customer;
use App\SnackSale\Domain\Model\Customer\CustomerRepository;
use App\SnackSale\Domain\Model\Snack\Ingredient\Ingredient;
use App\SnackSale\Domain\Model\Snack\Ingredient\IngredientRepository;
use App\SnackSale\Domain\Model\Snack\Menu\SnackMenu;
use App\SnackSale\Domain\Model\Snack\Menu\SnackMenuRepository;
use App\SnackSale\Domain\Model\Snack\Promotion\Promotion;
use App\SnackSale\Domain\Model\Snack\Promotion\PromotionRepository;
use App\SnackSale\Domain\Model\Snack\Snack;
use App\SnackSale\Domain\Model\Snack\SnackIngredient;
use App\SnackSale\Domain\Model\Snack\SnackRepository;
use App\Support\Collection;
use Money\Money;

class PopulateDefaultData implements SeederInterface
{
    private $snackRepository;
    private $snackMenuRepository;
    private $ingredientRepository;
    private $promotionRepository;
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    public function __construct(
        SnackRepository $snackRepository,
        SnackMenuRepository $snackMenuRepository,
        IngredientRepository $ingredientRepository,
        PromotionRepository $promotionRepository,
        CustomerRepository $customerRepository
    ) {
        $this->snackRepository = $snackRepository;
        $this->snackMenuRepository = $snackMenuRepository;
        $this->ingredientRepository = $ingredientRepository;
        $this->promotionRepository = $promotionRepository;
        $this->customerRepository = $customerRepository;
    }

    public function run()
    {
        // Create default ingredients
        $lettuce = $this->ingredientRepository->save(new Ingredient('Alface', Money::BRL(40)));
        $bacon = $this->ingredientRepository->save(new Ingredient('Bacon', Money::BRL(200)));
        $beefBurger = $this->ingredientRepository->save(new Ingredient('Hambúrguer de Carne', Money::BRL(300)));
        $egg = $this->ingredientRepository->save(new Ingredient('Ovo', Money::BRL(80)));
        $cheese = $this->ingredientRepository->save(new Ingredient('Queijo', Money::BRL(150)));

        // Create default snacks
        $snacks = new Collection([
            new Snack('X-Bacon', new Collection([
                new SnackIngredient($bacon),
                new SnackIngredient($beefBurger, 3),
                new SnackIngredient($cheese)
            ])),
            new Snack('X-Burger', new Collection([
                new SnackIngredient($beefBurger),
                new SnackIngredient($cheese)
            ])),
            new Snack('X-Egg', new Collection([
                new SnackIngredient($egg),
                new SnackIngredient($beefBurger),
                new SnackIngredient($cheese)
            ])),
            new Snack('X-Egg-Bacon', new Collection([
                new SnackIngredient($egg),
                new SnackIngredient($bacon),
                new SnackIngredient($beefBurger),
                new SnackIngredient($cheese)
            ])),
        ]);

        foreach ($snacks as $snack) {
            $this->snackRepository->save($snack);
        }

        // Create default menu
        $menu = new SnackMenu('Cardápio padrão', $snacks);
        $this->snackMenuRepository->save($menu);

        // Create default promotions
        $promotion1 = Promotion::createCombineAndPayLessPromotion('Light')
            ->shouldContainIngredient($lettuce)
            ->shouldNotContainIngredient($bacon)
            ->earnsDiscountPercentOf(10);

        $promotion2 = Promotion::createTakeMorePayLessPromotion('Muita carne')
            ->every(3)
            ->portionOfIngredient($beefBurger)
            ->customerPayFor(2);

        $promotion3 = Promotion::createTakeMorePayLessPromotion('Muito queijo')
            ->every(3)
            ->portionOfIngredient($cheese)
            ->customerPayFor(2);

        $this->promotionRepository->save($promotion1);
        $this->promotionRepository->save($promotion2);
        $this->promotionRepository->save($promotion3);

        // Create customers
        $this->customerRepository->save(new Customer('Felipe', 'felipe.ralc@gmail.com'));
    }
}