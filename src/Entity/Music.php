<?php

namespace App\Entity;

use App\Repository\MusicRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusicRepository::class)]
class Music
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?DateTime $duration = null;

    #[ORM\ManyToMany(targetEntity: Artist::class, inversedBy: 'featurings')]
    private Collection $featuring;

    #[ORM\ManyToOne(inversedBy: 'music')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Album $album = null;

    public function __toString(): string
    {
        return $this->getTitle() ?? '';
    }

    public function __construct()
    {
        $this->featuring = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDuration(): ?DateTime
    {
        return $this->duration;
    }

    public function getDurationString(): string
    {
        if ($this->duration === null) {
            return '';
        }

        if ($this->duration->format('H') === '00') {
            return $this->duration->format('i:s');
        }

        return $this->duration->format('H:i:s');
    }

    public function setDuration(DateTime $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Artist>
     */
    public function getFeaturing(): Collection
    {
        return $this->featuring;
    }

    public function addFeaturing(Artist $featuring): static
    {
        if (!$this->featuring->contains($featuring)) {
            $this->featuring->add($featuring);
        }

        return $this;
    }

    public function removeFeaturing(Artist $featuring): static
    {
        $this->featuring->removeElement($featuring);

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): static
    {
        $this->album = $album;

        return $this;
    }

}
