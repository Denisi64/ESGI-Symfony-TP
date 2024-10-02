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

    #[ORM\ManyToOne(inversedBy: 'userPlaylist')]
    private ?User $userId = null;

    #[ORM\ManyToOne(inversedBy: 'playlistSubscriptions')]
    private ?Playlist $playlistId = null;

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

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getPlaylistId(): ?Playlist
    {
        return $this->playlistId;
    }

    public function setPlaylistId(?Playlist $playlistId): static
    {
        $this->playlistId = $playlistId;

        return $this;
    }
}
