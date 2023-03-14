<?php

namespace App\Entity;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\UserGroupsRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;


#[ORM\Entity(repositoryClass: UserGroupsRepository::class)]
#[ApiResource (
    operations:[
        new Get(),
        new Put(),
        new Delete(),
        new GetCollection(),
        new Post()
    ]

)]
class UserGroups
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // #[Groups(['search'])]
    #[ORM\ManyToOne(inversedBy: 'userGroups')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $id_user = null;

    // #[Groups(['read','write'])]
    #[ORM\ManyToOne(inversedBy: 'userGroups')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Group $id_group = null;


    #[ORM\Column (nullable: true)]
    private ?bool $is_admin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdGroup(): ?Group
    {
        return $this->id_group;
    }

    public function setIdGroup(?Group $id_group): self
    {
        $this->id_group = $id_group;

        return $this;
    }

    public function isIsAdmin(): ?bool
    {
        return $this->is_admin;
    }

    public function setIsAdmin(bool $is_admin): self
    {
        $this->is_admin = $is_admin;

        return $this;
    }
}
