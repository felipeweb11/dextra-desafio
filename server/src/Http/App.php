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
use App\SnackSale\Infrastructure\Persistence\InMemoryRepository;
use App\SnackSale\Infrastructure\Persistence\InMemorySnackMenuRepository;
use App\SnackSale\Infrastructure\Persistence\InMemorySnackRepository;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Fractal;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    /**
     * @var App
     */
    private static $instance;

    /**
     * @var InMemoryRepository
     */
    private $storage;

    /**
     * Application seeders
     *
     * @var array
     */
    private $seeders = [
        PopulateDefaultData::class
    ];

    private $booted = false;

    public function __construct()
    {
        $this->storage = new InMemoryRepository;
    }

    private function configureContainer(ServerRequestInterface $request)
    {
        $container = new Container();
        $container->delegate(new ReflectionContainer);

        $container->share(InMemoryRepository::class, $this->storage);
        $container->share(ContainerInterface::class, $container);
        $container->share(CustomerRepository::class, $container->get(InMemoryCustomerRepository::class));
        $container->share(CustomSnackRepository::class, $container->get(InMemoryCustomSnackRepository::class));
        $container->share(IngredientRepository::class, $container->get(InMemoryIngredientRepository::class));
        $container->share(SnackMenuRepository::class, $container->get(InMemorySnackMenuRepository::class));
        $container->share(SnackRepository::class, $container->get(InMemorySnackRepository::class));
        $container->share(PromotionRepository::class, $container->get(InMemoryPromotionRepository::class));

        $container->share(SnackPriceCalculator::class, function() use ($container) {
            $promotions = $container->get(PromotionRepository::class)->all();
            $baseCalculator = new IngredientSumSnackPriceCalculator;
            return new PromotionalSnackPriceCalculator($baseCalculator, $promotions);
        });

        $container->share(Fractal\Manager::class, function() use ($request) {
            $manager = new Fractal\Manager();
            $manager->setSerializer(new Fractal\Serializer\ArraySerializer);
            $params = $request->getQueryParams();
            if (isset($params['include'])) {
                $manager->parseIncludes($params['include']);
            }
            return $manager;
        });

        return $container;
    }

    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        $container = $this->configureContainer($request);
        $this->bootIfNotBooted($container);
        $router = $this->configureRouter($container);
        return $router->dispatch($request);
    }

    private function configureRouter(ContainerInterface $container)
    {
        $strategy = new ApplicationStrategy;
        $strategy->setContainer($container);
        $router = new Router;
        $router->setStrategy($strategy);
        $this->mapRoutes($router);
        return $router;
    }

    private function mapRoutes(Router $router)
    {
        $router->get('/api/ingredients', 'App\Http\Api\Controllers\IngredientController::all');
        $router->get('/api/promotions', 'App\Http\Api\Controllers\PromotionController::all');
        $router->get('/api/snacks/menu', 'App\Http\Api\Controllers\SnackController::getDefaultSnackMenu');
        $router->post('/api/snacks/custom', 'App\Http\Api\Controllers\SnackController::createCustomSnack');
        $router->get('/api/snacks/custom/{id:uuid}', 'App\Http\Api\Controllers\SnackController::getCustomSnack');
        $router->post('/api/snacks/custom/{id:uuid}/ingredients', 'App\Http\Api\Controllers\SnackController::addCustomSnackIngredient');
        $router->delete('/api/snacks/custom/{id:uuid}/ingredients', 'App\Http\Api\Controllers\SnackController::removeCustomSnackIngredient');
    }

    private function runSeeders(ContainerInterface $container)
    {
        foreach ($this->seeders as $seederClass) {
            $seeder = $container->get($seederClass);
            $seeder->run();
        }
    }

    private function bootIfNotBooted(ContainerInterface $container)
    {
        if (! $this->booted) {
            $this->runSeeders($container);
            $this->booted = true;
        }
    }

    public static function instance()
    {
        return static::$instance ? static::$instance : static::$instance = new static();
    }

}