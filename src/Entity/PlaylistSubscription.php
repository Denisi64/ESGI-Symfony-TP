<?php

namespace App\Entity;

use App\Repository\PlaylistSubscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistSubscriptionRepository::class)]
class PlaylistSubscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $subscibedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscibedAt(): ?\DateTimeImmutable
    {
        return $this->subscibedAt;
    }

    public function setSubscibedAt(\DateTimeImmutable $subscibedAt): static
    {
        $this->subscibedAt = $subscibedAt;

        return $this;
    }
}
