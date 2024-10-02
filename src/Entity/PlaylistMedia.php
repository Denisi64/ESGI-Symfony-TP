<?php

namespace App\Entity;

use App\Repository\PlaylistMediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistMediaRepository::class)]
class PlaylistMedia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $addedAt = null;

    #[ORM\ManyToOne(inversedBy: 'playlistMedia')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Playlist $playlistId = null;

    /**
     * @var Collection<int, Media>
     */
    #[ORM\ManyToMany(targetEntity: Media::class, inversedBy: 'mediaPlaylist')]
    private Collection $mediaId;

    public function __construct()
    {
        $this->mediaId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddedAt(): ?\DateTimeImmutable
    {
        return $this->addedAt;
    }

    public function setAddedAt(\DateTimeImmutable $addedAt): static
    {
        $this->addedAt = $addedAt;

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

    /**
     * @return Collection<int, Media>
     */
    public function getMediaId(): Collection
    {
        return $this->mediaId;
    }

    public function addMediaId(Media $mediaId): static
    {
        if (!$this->mediaId->contains($mediaId)) {
            $this->mediaId->add($mediaId);
        }

        return $this;
    }

    public function removeMediaId(Media $mediaId): static
    {
        $this->mediaId->removeElement($mediaId);

        return $this;
    }
}
