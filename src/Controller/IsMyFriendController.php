<?php

namespace App\Controller;

use App\Entity\UserFriendShip;
use App\Repository\UserFriendShipRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IsMyFriendController extends AbstractController
{
    protected $user_repo;
    protected $user_friend_repo;

    public function __construct(UserRepository $userRepository, UserFriendShipRepository $userFriendShipRepository )
    {
        $this->user_repo = $userRepository;
        $this->user_friend_repo = $userFriendShipRepository;
    }

    public function __invoke(Request $request)
    {
        $id = $request->get('id');
        return $this->user_friend_repo->findBy(['id_user1' => $id ]);
    }
}

