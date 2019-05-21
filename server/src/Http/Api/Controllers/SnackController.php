<?php

namespace App\Http\Api\Controllers;

use App\Http\Api\Transformers\CustomSnackTransformer;
use App\Http\Api\Transformers\SnackMenuTransformer;
use App\SnackSale\Application\Commands\AddCustomSnackIngredientCommand;
use App\SnackSale\Application\Commands\CreateCustomSnackCommand;
use App\SnackSale\Application\Commands\RemoveCustomSnackIngredientCommand;
use App\SnackSale\Application\Services\SnackService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;

class SnackController extends Controller
{
    /**
     * @var SnackService
     */
    private $snackService;

    public function __construct(ContainerInterface $container, SnackService $snackService)
    {
        parent::__construct($container);
        $this->snackService = $snackService;
    }

    public function createCustomSnack(ServerRequestInterface $request)
    {
        $data = json_decode((string)$request->getBody());
        $command = new CreateCustomSnackCommand($data->customer_id);
        $customSnack = $this->snackService->createCustomSnack($command);
        return $this->entityResponse($customSnack, CustomSnackTransformer::class);
    }

    public function getCustomSnack(ServerRequestInterface $request, array $args)
    {
        return $this->entityResponse(
            $this->snackService->findCustomSnack($args['id']),
            CustomSnackTransformer::class
        );
    }

    public function addCustomSnackIngredient(ServerRequestInterface $request, array $args)
    {
        $data = json_decode((string)$request->getBody());
        $command = new AddCustomSnackIngredientCommand($args['id'], $data->ingredient_id, $data->quantity);
        $this->snackService->addCustomSnackIngredient($command);
        return $this->jsonResponse([
            'message' => 'Ingredient added'
        ]);
    }

    public function removeCustomSnackIngredient(ServerRequestInterface $request, array $args)
    {
        $data = $request->getQueryParams();
        $command = new RemoveCustomSnackIngredientCommand($args['id'], $data['ingredient_id'], $data['quantity']);
        $this->snackService->removeCustomSnackIngredient($command);
        return $this->jsonResponse([
            'message' => 'Ingredient removed'
        ]);
    }

    public function getDefaultSnackMenu()
    {
        return $this->entityResponse(
            $this->snackService->getDefaultSnackMenu(),
            SnackMenuTransformer::class
        );
    }

}