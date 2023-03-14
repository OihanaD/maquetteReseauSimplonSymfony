<?php

namespace App\Entity;


use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use App\Controller\AddFriendsGroupController;
use App\Controller\IsMyFriendController;
use App\Repository\UserFriendShipRepository;
use Doctrine\ORM\Mapping as ORM;
#[ApiResource(
    operations:[
        new Get(),
        // new Post(name: 'addfriends', uriTemplate: '/{idUser1}/{idUser2}/addfriends', controller: AddFriendsGroupController::class, denormalizationContext: ['groups' => ['addFriends']]),
        new Put(),
        new Delete(),
        // new GetCollection(name: 'isFriend', uriTemplate: '/{id}/friends', controller: IsMyFriendController::class, normalizationContext: ['groups' => ['friends']]),
        new GetCollection(),
        new Post()
    ]
)]
#[ORM\Entity(repositoryClass: UserFriendShipRepository::class)]
// #[ApiResource]
class UserFriendShip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userFriendShips')]
    #[Groups(['addFriends'])]
    private ?User $id_user1 = null;
    #[ORM\ManyToOne(inversedBy: 'userFriendShips')]
    #[Groups(['search', 'addFriends', 'read'])]
    private ?User $id_user2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser1(): ?User
    {
        return $this->id_user1;
    }

    public function setIdUser1(?User $id_user1): self
    {
        $this->id_user1 = $id_user1;

        return $this;
    }

    public function getIdUser2(): ?User
    {
        return $this->id_user2;
    }

    public function setIdUser2(?User $id_user2): self
    {
        $this->id_user2 = $id_user2;

        return $this;
    }
}
