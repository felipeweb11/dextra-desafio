<?php

namespace App\Http\Api\Controllers;

use App\Http\Api\Transformers\PromotionTransformer;
use App\SnackSale\Domain\Model\Snack\Promotion\PromotionRepository;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;

class PromotionController extends Controller
{
    /**
     * @var PromotionRepository
     */
    private $promotionRepository;

    public function __construct(ContainerInterface $container, PromotionRepository $promotionRepository)
    {
        parent::__construct($container);
        $this->promotionRepository = $promotionRepository;
    }

    public function all(ServerRequestInterface $request)
    {
        return $this->entityResponse(
            $this->promotionRepository->all(),
            PromotionTransformer::class
        );
    }
}