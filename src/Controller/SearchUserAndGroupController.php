<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\User;
use App\Entity\UserFriendShip;
use App\Repository\GroupRepository;
use App\Repository\UserFriendShipRepository;
use App\Repository\UserGroupsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchUserAndGroupController extends AbstractController
{
    protected $user_repo;
    protected $group_repo;

    public function __construct(UserRepository $userRepository, GroupRepository $groupRepository  )
    {
        $this->user_repo = $userRepository;
        $this->group_repo = $groupRepository;
    }

    public function __invoke(Request $request)
    {
        $id = $request->get('id');
         $resultgroups = $this->user_repo->getMoreGroups($id);
         $resultfriends = $this->user_repo->getMoreFriends($id);
         $result = array_merge($resultgroups, $resultfriends);
         return $result;
    }
}
