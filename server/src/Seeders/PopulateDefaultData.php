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
        $lettuce = $this->ingredientRepository->save(new Ingredient('Alface', Money::BRL(40), 'lettuce.png'));
        $bacon = $this->ingredientRepository->save(new Ingredient('Bacon', Money::BRL(200), 'bacon.png'));
        $beefBurger = $this->ingredientRepository->save(new Ingredient('Hambúrguer', Money::BRL(300), 'beef.png'));
        $egg = $this->ingredientRepository->save(new Ingredient('Ovo', Money::BRL(80), 'egg.png'));
        $cheese = $this->ingredientRepository->save(new Ingredient('Queijo', Money::BRL(150), 'cheese.png'));

        // Create default snacks
        $snacks = new Collection([
            new Snack('X-Bacon', new Collection([
                new SnackIngredient($bacon),
                new SnackIngredient($beefBurger),
                new SnackIngredient($cheese)
            ]), 'x-bacon.png'),
            new Snack('X-Burger', new Collection([
                new SnackIngredient($beefBurger),
                new SnackIngredient($cheese)
            ]), 'x-burger.png'),
            new Snack('X-Egg', new Collection([
                new SnackIngredient($egg),
                new SnackIngredient($beefBurger),
                new SnackIngredient($cheese)
            ]), 'x-egg.png'),
            new Snack('X-Egg-Bacon', new Collection([
                new SnackIngredient($egg),
                new SnackIngredient($bacon),
                new SnackIngredient($beefBurger),
                new SnackIngredient($cheese)
            ]), 'x-egg-bacon.png'),
        ]);

        foreach ($snacks as $snack) {
            $this->snackRepository->save($snack);
        }

        // Create default menu
        $menu = new SnackMenu('Cardápio padrão', $snacks);
        $this->snackMenuRepository->save($menu);

        // Create default promotions
        $promotion1 = Promotion::createCombineAndPayLessPromotion('Light')
            ->withDescription('Ganhe 10% de desconto se o lanche tiver alface e não tiver bacon')
            ->shouldContainIngredient($lettuce)
            ->shouldNotContainIngredient($bacon)
            ->earnsDiscountPercentOf(10);

        $promotion2 = Promotion::createTakeMorePayLessPromotion('Muita carne')
            ->withDescription('A cada 3 porções de carne você paga por apenas 2')
            ->every(3)
            ->portionOfIngredient($beefBurger)
            ->customerPayFor(2);

        $promotion3 = Promotion::createTakeMorePayLessPromotion('Muito queijo')
            ->withDescription('A cada 3 porções de queijo você paga por apenas 2')
            ->every(3)
            ->portionOfIngredient($cheese)
            ->customerPayFor(2);

        $this->promotionRepository->save($promotion1);
        $this->promotionRepository->save($promotion2);
        $this->promotionRepository->save($promotion3);

        // Create customer
        $customer = new Customer('Felipe', 'felipe.ralc@gmail.com');
        $customer->setId('984376ee-382d-48d3-874b-64ca4e99b2ec');
        $this->customerRepository->save($customer);

    }
}