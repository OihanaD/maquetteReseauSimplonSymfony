<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserFriendShip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    protected $em;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    public function search($id, $parameter){
        //get groupe
        if($parameter == 1){
            $sql = 'SELECT u.id,u.surname,g.name FROM App\Entity\User u LEFT JOIN u.userGroups ug LEFT JOIN ug.id_group g WHERE g.name IS NOT NULL AND u.id = ?1';

            $query = $this->getEntityManager()->createQuery($sql);
            $query->setParameter(1, $id);


            return $query->getResult(); 
           
        }
        //get groupe is_admin
        elseif($parameter == 2){
            $sql = 'SELECT u.id,u.surname,u.image,g.name, ug.is_admin FROM App\Entity\User u LEFT JOIN u.userGroups ug LEFT JOIN ug.id_group g WHERE g.name IS NOT NULL AND u.id = ?1 AND ug.is_admin = true';

            $query = $this->getEntityManager()->createQuery($sql);
            $query->setParameter(1, $id);


            return $query->getResult(); 
           
        }
        //get userFriend
        elseif($parameter == 3){
            $sql = "SELECT u1.name FROM App\Entity\UserFriendShip uf LEFT JOIN uf.id_user1 u1 WHERE uf.id_user2 = ?1";
            $sql2 = "SELECT u2.name FROM App\Entity\UserFriendShip uf LEFT JOIN uf.id_user2 u2 WHERE uf.id_user1 = ?1";
            $query1 = $this->getEntityManager()->createQuery($sql);
            $query1->setParameter(1, $id);
            $query2 = $this->getEntityManager()->createQuery($sql2);
            $query2->setParameter(1, $id);


            $result1= $query1->getResult(); 
            $result2= $query2->getResult(); 
            return array_merge($result1, $result2);
           
        }
        //get all
        elseif($parameter == 0){
            $sqlfriend1 = "SELECT u1.name FROM App\Entity\UserFriendShip uf LEFT JOIN uf.id_user1 u1 WHERE uf.id_user2 = ?1";
            $sqlfriend2 = "SELECT u2.name FROM App\Entity\UserFriendShip uf LEFT JOIN uf.id_user2 u2 WHERE uf.id_user1 = ?1";
            $sqlusergroupsadmin = 'SELECT u.id,u.surname,u.image,g.name, ug.is_admin FROM App\Entity\User u LEFT JOIN u.userGroups ug LEFT JOIN ug.id_group g WHERE g.name IS NOT NULL AND u.id = ?1 AND ug.is_admin = true';
            $sqlallgrps = 'SELECT u.id,u.surname,g.name FROM App\Entity\User u LEFT JOIN u.userGroups ug LEFT JOIN ug.id_group g WHERE g.name IS NOT NULL AND u.id = ?1';

            $query1 = $this->getEntityManager()->createQuery($sqlfriend1);
            $query1->setParameter(1, $id);
            $query2 = $this->getEntityManager()->createQuery($sqlfriend2);
            $query2->setParameter(1, $id);
            $query3 = $this->getEntityManager()->createQuery($sqlusergroupsadmin);
            $query3->setParameter(1, $id);
            $query4 = $this->getEntityManager()->createQuery($sqlallgrps);
            $query4->setParameter(1, $id);


            $result1= $query1->getResult(); 
            $result2= $query2->getResult(); 
            $result3= $query3->getResult(); 
            $result4= $query4->getResult(); 
            return array_merge($result1, $result2,$result3,$result4);
           
        }
       

        
    }
    public function getMoreFriends($id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT name FROM user WHERE name NOT IN 
            (SELECT name FROM user as us
            LEFT JOIN user_friend_ship as sf ON us.id = sf.id_user1_id OR us.id = sf.id_user2_id
            WHERE sf.id_user1_id = :id OR sf.id_user2_id = :id);;
            ';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);
        return $resultSet->fetchAllAssociative();
    }

    public function getMoreGroups($id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT name FROM `group` WHERE name NOT IN (SELECT name FROM `group` as g LEFT JOIN user_groups as ug ON g.id = ug.id_group_id WHERE ug.id_user_id = :id);';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);
        return $resultSet->fetchAllAssociative();
    }
    public function addFriends($idUser1, $idUser2){
        var_dump($idUser1);
        $newRelation = new UserFriendShip;
        $newRelation->setIdUser1($idUser1);
        $newRelation->setIdUser2($idUser2);
        $this->getEntityManager()->persist($newRelation);

        $this->getEntityManager()->flush();
        
    }

    }
//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
// }
