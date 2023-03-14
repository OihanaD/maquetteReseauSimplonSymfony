<?php

namespace App\Controller;

use App\Entity\UserFriendShip;
use App\Repository\UserFriendShipRepository;
use App\Repository\UserGroupsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ListGroupsController extends AbstractController
{
    protected $user_repo;
    protected $user_group_repo;

    public function __construct(UserRepository $userRepository, UserGroupsRepository $userGroupsRepository )
    {
        $this->user_repo = $userRepository;
        $this->user_group_repo = $userGroupsRepository;
    }

    public function __invoke(Request $request)
    {
        $id = $request->get('id');
        return $this->user_group_repo->findBy(['id_user' => $id ]);
    }
}

