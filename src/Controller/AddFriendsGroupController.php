<?php

namespace App\Controller;

use App\Entity\UserFriendShip;
use App\Entity\UserGroups;
use App\Repository\GroupRepository;
use App\Repository\UserFriendShipRepository;
use App\Repository\UserGroupsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Api\IriConverterInterface;

class AddFriendsGroupController extends AbstractController
{
    protected $user_repo;
    protected $user_friend_repo;
    protected $group_repo;
    protected $user_group_repo;
    protected $objectManager;

    private $iriConverter;

    public function __construct(UserRepository $userRepository, UserFriendShipRepository $userFriendShipRepository, GroupRepository $groupRepository, UserGroupsRepository $userGroupsRepository, EntityManagerInterface $objectManager, IriConverterInterface $iriConverter)
    {    
        $this->user_repo = $userRepository;
        $this->user_friend_repo = $userFriendShipRepository;
        $this->group_repo = $groupRepository;
        $this->user_group_repo = $userGroupsRepository;
        $this->objectManager = $objectManager;
        $this->iriConverter = $iriConverter;
    }

    public function __invoke(Request $request)
    {
        $id = $request->attributes->get('id'); 

        $returnidactive = $this->user_repo->find($id);
        $data = json_decode($request->getContent(), true);
        if (!empty($data["FriendShips"])){
            foreach ($data as $user) {
                //$returnnewfriend = $this->user_repo->find($user);
                foreach ($user as $iri) {
                    dd($iri);
                }
                dd($user);
                if ($user){
                    $newRelation = new UserFriendShip;
                    $newRelation->setIdUser1($returnidactive);
                    $newRelation->setIdUser2($user);
                    $this->objectManager->persist($newRelation);
    
                    $this->objectManager->flush();  
                }
                
                
            }
        }
        $data['userFriendShips'] = $this->iriConverter->getIriFromResource(Resource : User::class, context: ['uri_variables' => ['id' => $data['userFriendShips']]]);
        dd($data['userFriendShips']);
        if (empty($data['UserGroups'])){
            foreach ($data["userGroups"] as $groups) {
                
                $returnnewgroup = $this->group_repo->find($groups);
                
                $newgroup = new UserGroups;
               
                $newgroup->setIdUser($returnidactive);
                $newgroup->setIdGroup($returnnewgroup);
                $newgroup->setIsAdmin(false);
                
                $this->objectManager->persist($newgroup);
                
    
                $this->objectManager->flush();
                
            }
        }
   
    }
}

