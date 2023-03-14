<?php

namespace App\Controller;

use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchInBddController extends AbstractController
{
    protected $user_repo;
    protected $group_repo;

    public function __construct(UserRepository $userRepository, GroupRepository $groupRepository)
    {
        $this->user_repo = $userRepository;
        $this->group_repo = $groupRepository;
    }

    public function __invoke(Request $request)
    {
        $id = $request->get('id');
       $user = $this->user_repo->findBy(['id' => $id]);
       $group = $this->group_repo->findBy(['id' => $id]);

       if ($user){
        return $user;
       }elseif($group){
        return $group;
       }
    }
}
