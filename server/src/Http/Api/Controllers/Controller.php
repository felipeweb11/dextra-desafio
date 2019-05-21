<?php

namespace App\Http\Api\Controllers;

use App\SnackSale\Domain\Model\Entity;
use App\Support\Collection;
use Exception;
use League\Fractal;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use React\Http\Response;

abstract class Controller
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function jsonResponse($data, $status = 200): ResponseInterface
    {
        if (is_string($data)) {
            $body = $data;
        } elseif (is_array($data)) {
            $body = json_encode($data);
        } else {
            throw new Exception('The given data could not be converted to json string');
        }

        return new Response($status, ['Content-Type' => 'application/json'], $body);
    }

    public function entityResponse($entity, string $transformerClass): ResponseInterface
    {
        $fractal = $this->container->get(Fractal\Manager::class);
        $transformer = $this->container->get($transformerClass);

        if ($entity instanceof Entity) {
            $resource = new Fractal\Resource\Item($entity, $transformer);
        } else if ($entity instanceof Collection) {
            $resource = new Fractal\Resource\Collection($entity, $transformer);
        } else {
            throw new Exception('The given data for serialization should be an instance of Entity or Collection');
        }

        return $this->jsonResponse($fractal->createData($resource)->toJson());
    }
}