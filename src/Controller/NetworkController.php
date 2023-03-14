<?php

namespace App\Controller;

use App\Entity\UserFriendShip;
use App\Repository\UserFriendShipRepository;
use App\Repository\UserGroupsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class NetworkController extends AbstractController
{
    protected $user_repo;
    protected $user_friend_repo;
    protected $user_group_repo;

    public function __construct(UserRepository $userRepository, UserFriendShipRepository $userFriendShipRepository, UserGroupsRepository $userGroupsRepository )
    {
        $this->user_repo = $userRepository;
        $this->user_friend_repo = $userFriendShipRepository;
    }

    public function __invoke(Request $request)
    {
        $id = $request->get('id');
        $parameter = $request->get('parameter');
        return $this->user_repo->search($id, $parameter);
    }
}

