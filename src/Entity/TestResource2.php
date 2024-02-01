<?php

namespace App\Entity;

use App\Repository\TestResource2Repository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TestResource2Repository::class)]
class TestResource2
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Groups(['public','admin'])] 
    private ?string $public_data = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Groups(['subscriber','admin'])] 
    private ?string $private_user_data = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Groups(['subscriber','admin'])] 
    private ?string $data_for_subscribed_users = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Groups(['admin'])] // Group for admin data
    private ?string $admin_only_data = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublicData(): ?string
    {
        return $this->public_data;
    }

    public function setPublicData(string $public_data): static
    {
        $this->public_data = $public_data;

        return $this;
    }

    public function getPrivateUserData(): ?string
    {
        return $this->private_user_data;
    }

    public function setPrivateUserData(string $private_user_data): static
    {
        $this->private_user_data = $private_user_data;

        return $this;
    }

    public function getDataForSubscribedUsers(): ?string
    {
        return $this->data_for_subscribed_users;
    }

    public function setDataForSubscribedUsers(string $data_for_subscribed_users): static
    {
        $this->data_for_subscribed_users = $data_for_subscribed_users;

        return $this;
    }

    public function getAdminOnlyData(): ?string
    {
        return $this->admin_only_data;
    }

    public function setAdminOnlyData(string $admin_only_data): static
    {
        $this->admin_only_data = $admin_only_data;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
