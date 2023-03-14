<?php

namespace App\State;

use App\Entity\UserFriendShip;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

class UserFriendShipStateProvider implements ProviderInterface
{
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        var_dump($context);
        dd($operation);
        return new UserFriendShip();
        // Retrieve the state from somewhere
    }
}
