<?php

namespace App\Http\Api\Controllers;

use App\Http\Api\Transformers\IngredientTransformer;
use App\SnackSale\Domain\Model\Snack\Ingredient\IngredientRepository;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;

class IngredientController extends Controller
{
    /**
     * @var IngredientRepository
     */
    private $ingredientRepository;

    public function __construct(ContainerInterface $container, IngredientRepository $ingredientRepository)
    {
        parent::__construct($container);
        $this->ingredientRepository = $ingredientRepository;
    }

    public function all(ServerRequestInterface $request)
    {
        return $this->entityResponse(
            $this->ingredientRepository->all(),
            IngredientTransformer::class
        );
    }
}