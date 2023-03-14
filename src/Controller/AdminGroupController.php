<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminGroupController extends AbstractController
{
    protected $user_repo;

    public function __construct(UserRepository $userRepository)
    {
        $this->user_repo = $userRepository;
    }

    public function __invoke(Request $request)
    {
        $id = $request->get('id');
        return $this->user_repo->findBy(['id' => $id ,'is_active' => true]);
    }
}
