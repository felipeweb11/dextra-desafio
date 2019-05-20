<?php

namespace App\Http\Api\Controllers;

use App\SnackSale\Application\Commands\CreateCustomSnackCommand;
use App\SnackSale\Application\Services\SnackService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

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
        $snackId = $this->snackService->createCustomSnack($command);

        return $this->json([
            'data' => [
                'snack_id' => $snackId
            ]
        ]);
    }

    public function getDefaultSnackMenu(ServerRequestInterface $request)
    {
        $menu = $this->snackService->getDefaultSnackMenu();
        return $this->json($menu);
    }

}