<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["show", "show_app"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["show", "show_app"])]
    private $service;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["show", "show_app"])]
    private $source;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["show", "show_app"])]
    private $space;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["show", "show_app"])]
    private $room;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["show", "show_app"])]
    private $typeRoom;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'applications')]
    #[Groups(["show_app"])]
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getSpace(): ?string
    {
        return $this->space;
    }

    public function setSpace(string $space): self
    {
        $this->space = $space;

        return $this;
    }

    public function getRoom(): ?string
    {
        return $this->room;
    }

    public function setRoom(string $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getTypeRoom(): ?string
    {
        return $this->typeRoom;
    }

    public function setTypeRoom(string $typeRoom): self
    {
        $this->typeRoom = $typeRoom;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
