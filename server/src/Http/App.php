<?php

namespace App\Http;

use App\Seeders\PopulateDefaultData;
use App\SnackSale\Domain\Model\Customer\CustomerRepository;
use App\SnackSale\Domain\Model\Snack\CustomSnackRepository;
use App\SnackSale\Domain\Model\Snack\Ingredient\IngredientRepository;
use App\SnackSale\Domain\Model\Snack\Menu\SnackMenuRepository;
use App\SnackSale\Domain\Model\Snack\Pricing\Calculators\IngredientSumSnackPriceCalculator;
use App\SnackSale\Domain\Model\Snack\Pricing\Calculators\PromotionalSnackPriceCalculator;
use App\SnackSale\Domain\Model\Snack\Promotion\PromotionRepository;
use App\SnackSale\Domain\Model\Snack\SnackPriceCalculator;
use App\SnackSale\Domain\Model\Snack\SnackRepository;
use App\SnackSale\Infrastructure\Persistence\InMemoryCustomerRepository;
use App\SnackSale\Infrastructure\Persistence\InMemoryCustomSnackRepository;
use App\SnackSale\Infrastructure\Persistence\InMemoryIngredientRepository;
use App\SnackSale\Infrastructure\Persistence\InMemoryPromotionRepository;
use App\SnackSale\Infrastructure\Persistence\InMemorySnackMenuRepository;
use App\SnackSale\Infrastructure\Persistence\InMemorySnackRepository;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Container\ContainerInterface;

class App
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var Router
     */
    private $router;

    private $seeders = [
        PopulateDefaultData::class
    ];

    public function __construct()
    {
        $this->configureContainer();
    }

    private function configureContainer()
    {
        $this->container = new Container();
        $this->container->delegate(new ReflectionContainer);

        $this->container->add(ContainerInterface::class, $this->container);
        $this->container->add(CustomerRepository::class, $this->container->get(InMemoryCustomerRepository::class));
        $this->container->add(CustomSnackRepository::class, $this->container->get(InMemoryCustomSnackRepository::class));
        $this->container->add(IngredientRepository::class, $this->container->get(InMemoryIngredientRepository::class));
        $this->container->add(SnackMenuRepository::class, $this->container->get(InMemorySnackMenuRepository::class));
        $this->container->add(SnackRepository::class, $this->container->get(InMemorySnackRepository::class));
        $this->container->add(PromotionRepository::class, $this->container->get(InMemoryPromotionRepository::class));

        $this->container->add(SnackPriceCalculator::class, function() {
            $promotions = $this->container->get(PromotionRepository::class)->all();
            $baseCalculator = new IngredientSumSnackPriceCalculator;
            return new PromotionalSnackPriceCalculator($baseCalculator, $promotions);
        });
    }

    private function configureRouter()
    {
        $strategy = new ApplicationStrategy;
        $strategy->setContainer($this->container);
        $this->router = new Router;
        $this->router->setStrategy($strategy);
        $this->mapRoutes();
    }

    private function mapRoutes()
    {
        $this->router->get('/api/snacks/menu', 'App\Http\Api\Controllers\SnackController::getDefaultSnackMenu');
        $this->router->post('/api/snacks/custom', 'App\Http\Api\Controllers\SnackController::createCustomSnack');
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function getRouter(): Router
    {
        $this->configureRouter();
        return $this->router;
    }

    public function seed()
    {
        foreach ($this->seeders as $seederClass) {
            $seeder = $this->container->get($seederClass);
            $seeder->run();
        }
    }

}