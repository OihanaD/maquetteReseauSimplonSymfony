<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use App\Controller\AdminGroupController;
use App\Controller\NetworkController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Patch;
use App\Controller\AddFriendsGroupController;
use App\Controller\SearchUserAndGroupController;

#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    operations:[
        new Get(),
        new Put(),
        new Delete(),
        new GetCollection(name: 'search', uriTemplate: '/{id}/network/{parameter}', controller: NetworkController::class, normalizationContext: ['groups' => ['search']]),
        new Get(name: 'activeUser', uriTemplate: '/users/{id}/activate', controller: AdminGroupController::class),
        new GetCollection(),
        new Patch(name: 'addFriendToActualNetwork', uriTemplate: '/{id}/network/addFriend', controller: AddFriendsGroupController::class, validate:false),
        new GetCollection(name: 'searchAll', uriTemplate: '/{id}/search', controller: SearchUserAndGroupController::class),
        new Post()
    ]
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table('User')]
// #[ApiResource]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    
    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    
    #[ORM\Column(length: 255)]
    // #[Groups(['search'])]
    #[Groups(['read'])]
    private ?string $surname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read'])]

    private ?string $mail = null;

   
    #[ORM\Column(length: 255, nullable: true)]
    // #[Groups(['search'])]
    #[Groups(['read'])]

    private ?string $image = null;

    // #[Groups(['read', 'write'])]
    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: UserGroups::class)]
    #[Groups(['read'])]

    private Collection $userGroups;

    #[ORM\OneToMany(mappedBy: 'id_user1', targetEntity: UserFriendShip::class)]
    #[Groups(['read'])]
    private Collection $userFriendShips;


    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?bool $is_active = false;

    public function __construct()
    {
        $this->userGroups = new ArrayCollection();
        $this->userFriendShips = new ArrayCollection();
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, UserGroups>
     */
    public function getUserGroups(): Collection
    {
        return $this->userGroups;
    }

    public function addUserGroup(UserGroups $userGroup): self
    {
        if (!$this->userGroups->contains($userGroup)) {
            $this->userGroups->add($userGroup);
            $userGroup->setIdUser($this);
        }

        return $this;
    }

    public function removeUserGroup(UserGroups $userGroup): self
    {
        if ($this->userGroups->removeElement($userGroup)) {
            // set the owning side to null (unless already changed)
            if ($userGroup->getIdUser() === $this) {
                $userGroup->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserFriendShip>
     */
    public function getUserFriendShips(): Collection
    {
        return $this->userFriendShips;
    }
    public function addUserFriendShip(UserFriendShip $userFriendShip1): self
    {
        if (!$this->userFriendShips->contains($userFriendShip1)) {
            $this->userFriendShips->add($userFriendShip1);
            $userFriendShip1->setIdUser1($this);
          
        }
        return $this;
    }



    public function removeUserFriendShip(UserFriendShip $userFriendShip): self
    {
        if ($this->userFriendShips->removeElement($userFriendShip)) {
            // set the owning side to null (unless already changed)
            if ($userFriendShip->getIdUser1() === $this) {
                $userFriendShip->setIdUser1(null);
            }
           
        }

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

}
