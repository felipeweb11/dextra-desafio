<?php

namespace App\Http\Api\Controllers;

use App\Http\Api\Serializers\SnackMenuSerializer;
use App\SnackSale\Domain\Model\Entity;
use App\Support\Contracts\Jsonable;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use React\Http\Response;
use ReflectionClass;

abstract class Controller
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function json($data, $status = 200): ResponseInterface
    {
        if (is_string($data)) {
            $body = $data;
        } elseif (is_array($data)) {
            $body = json_encode($data);
        } elseif ($data instanceof Entity) {
            $body = $this->serializeEntity($data);
        } elseif ($data instanceof Jsonable) {
            $body = $data->toJson();
        }

        return new Response($status, [
            'Content-Type' => 'application/json'
        ], $body);
    }

    private function serializeEntity(Entity $entity): string
    {
        $reflection = new ReflectionClass($entity);
        $serializerClass = sprintf('App\Http\Api\Serializers\\%sSerializer', $reflection->getShortName());
        if (class_exists($serializerClass)) {
            $serializer = $this->container->get($serializerClass);
            return $serializer->serialize($entity);
        }
        return $entity->toJson();
    }
}