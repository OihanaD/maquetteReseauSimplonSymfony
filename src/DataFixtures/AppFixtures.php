<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\User;
use App\Entity\UserFriendShip;
use App\Entity\UserGroups;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Types\VarDateTimeImmutableType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\VarDumper\VarDumper;

class AppFixtures extends Fixture
{
    
    public function load(ObjectManager $manager): void
    {
        
      
        for ($i = 0; $i < 20; $i++) {
            if($i === 0){
                $users= [];
                $groups = [];
            }
            
            $user = new User();
            $user->setName('user '.$i);
            if ($user->getName() === 'user 2'|| $user->getName() === 'user 4' || $user->getName() === 'user 6' ||$user->getName() === 'user 8' || $user->getName() === 'user 10'){
                $user->setSurname('this is a super surname of the world for the user '.$i);
            }else{
                $user->setSurname('surname '.$i);
            }
            
            $user->setMail('user '.$i . '@mail.com');
            $user->setPassword(password_hash('paswordUser_' . $i, PASSWORD_DEFAULT));
            
            if ($i < 6){
                
                $user->setImage('image' . $i . '.png');
            }elseif($i < 10 && $i >= 6) {
                $user->setImage('image' . $i . '.jpg');
            }elseif($i < 15 && $i >= 10) {
                $user->setImage('image' . $i . '.jpeg');
            }
            if($user->getName()== 'user 19' || $user->getName()== 'user 19'){
                $user->setIsActive(false);
            }else{
                $user->setIsActive(true);
            }
            array_push($users, $user);
            if ($i < 10){
                $group = new Group();                
                $group->setName('Groupe ' . $i);
                
            }
            $groups[] = $group;
            $manager->persist($user);
            
            $manager->persist($group);          
  
        }
        foreach($users as $user){
            if ($user->getName() == 'user 3'){
                foreach ($groups as $group){
                    if ($group->getName() == 'Groupe 2' || $group->getName() == 'Groupe 5' || $group->getName() == 'Groupe 3' || $group->getName() == 'Groupe 6'){
                        $userGroup = new UserGroups();
                        $userGroup->setIdUser($user);
                        $userGroup->setIdGroup($group);
                        $userGroup->setIsAdmin(true);
                        $group->addUserGroup($userGroup);
                        $user->addUserGroup($userGroup);
                        $manager->persist($userGroup);
                    }
                 
                }
                
            }
            if ($user->getName() == 'user 5'){
                foreach ($groups as $group){
                    if ($group->getName() == 'Groupe 0' || $group->getName() == 'Groupe 1' || $group->getName() == 'Groupe 3' || $group->getName() == 'Groupe 6'){
                        $userGroup = new UserGroups();
                        $userGroup->setIdUser($user);
                        $userGroup->setIdGroup($group);
                        $userGroup->setIsAdmin(false);
                        $group->addUserGroup($userGroup);
                        $user->addUserGroup($userGroup);
                        $manager->persist($userGroup);
                    }
                    if ($group->getName() == 'Groupe 4'){
                        $userGroup = new UserGroups();
                        $userGroup->setIdUser($user);
                        $userGroup->setIdGroup($group);
                        $userGroup->setIsAdmin(true);
                        $group->addUserGroup($userGroup);
                        $user->addUserGroup($userGroup);
                        $manager->persist($userGroup);
                    }
                 
                }
                
            }
           
            
        }
        
        for ($i = 0; $i < 20; $i++) {
            $friendship = new Userfriendship();
            $friendship->setIdUser1($users[random_int(0, 19)]);
            
            $friendship->setIdUser2($users[random_int(0, 19)]);

        $manager->persist($friendship);
        // var_dump($friendship);
    }
        $manager->flush();
        

                
    }
}
