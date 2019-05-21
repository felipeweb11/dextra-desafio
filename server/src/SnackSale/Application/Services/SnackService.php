<?php

namespace App\SnackSale\Application\Services;

use App\SnackSale\Application\Commands\AddCustomSnackIngredientCommand;
use App\SnackSale\Application\Commands\CreateCustomSnackCommand;
use App\SnackSale\Application\Commands\RemoveCustomSnackIngredientCommand;
use App\SnackSale\Domain\Model\Customer\CustomerRepository;
use App\SnackSale\Domain\Model\Snack\CustomSnack;
use App\SnackSale\Domain\Model\Snack\CustomSnackRepository;
use App\SnackSale\Domain\Model\Snack\Ingredient\IngredientRepository;
use App\SnackSale\Domain\Model\Snack\Menu\SnackMenu;
use App\SnackSale\Domain\Model\Snack\Menu\SnackMenuRepository;
use App\SnackSale\Domain\Model\Snack\SnackRepository;
use InvalidArgumentException;

class SnackService
{
    private $customerRepository;
    private $customSnackRepository;
    private $ingredientRepository;
    private $snackRepository;
    private $snackMenuRepository;

    public function __construct(
        CustomerRepository $customerRepository,
        CustomSnackRepository $customSnackRepository,
        IngredientRepository $ingredientRepository,
        SnackMenuRepository $snackMenuRepository,
        SnackRepository $snackRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->customSnackRepository = $customSnackRepository;
        $this->ingredientRepository = $ingredientRepository;
        $this->snackMenuRepository = $snackMenuRepository;
        $this->snackRepository = $snackRepository;
    }

    public function createCustomSnack(CreateCustomSnackCommand $command): CustomSnack
    {
        $customer = $this->customerRepository->find($command->customerId);

        if (! $customer) {
            throw new InvalidArgumentException(sprintf('Unknown customer of id %s', $command->customerId));
        }

        $customSnack = new CustomSnack($customer);
        $this->customSnackRepository->save($customSnack);
        return $customSnack;
    }

    public function findCustomSnack(string $id)
    {
        $customSnack = $this->customSnackRepository->find($id);

        if (! $customSnack) {
            throw new InvalidArgumentException(sprintf('Unknown custom snack of id %s', $id));
        }

        return $customSnack;
    }

    public function addCustomSnackIngredient(AddCustomSnackIngredientCommand $command) {
        $customSnack = $this->customSnackRepository->find($command->customSnackId);

        if (! $customSnack) {
            throw new InvalidArgumentException(sprintf('Unknown custom snack of id %s', $command->customSnackId));
        }

        $ingredient = $this->ingredientRepository->find($command->ingredientId);

        if (! $ingredient) {
            throw new InvalidArgumentException(sprintf('Unknown ingredient of id %s', $command->ingredientId));
        }

        $customSnack->addIngredient($ingredient, $command->quantity);
        $this->customSnackRepository->save($customSnack);
    }

    public function removeCustomSnackIngredient(RemoveCustomSnackIngredientCommand $command) {
        $customSnack = $this->customSnackRepository->find($command->customSnackId);

        if (! $customSnack) {
            throw new InvalidArgumentException(sprintf('Unknown custom snack of id %s', $command->customSnackId));
        }

        $ingredient = $this->ingredientRepository->find($command->ingredientId);

        if (! $ingredient) {
            throw new InvalidArgumentException(sprintf('Unknown ingredient of id %s', $command->ingredientId));
        }

        $customSnack->removeIngredient($ingredient, $command->quantity);
        $this->customSnackRepository->save($customSnack);
    }

    public function getDefaultSnackMenu():? SnackMenu
    {
        return $this->snackMenuRepository->defaultMenu();
    }

}