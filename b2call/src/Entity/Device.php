<?php

namespace App\Entity;

use App\Helper\Status\DeviceStatus;
use App\Helper\Status\StatusTrait;
use App\Repository\DeviceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
class Device
{
    use StatusTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Client::class, cascade: ["persist", "remove"], inversedBy: 'devices')]
    private $client;

    #[ORM\Column(type: 'string', length: 255)]
    private $token;

    #[ORM\Column(type: 'datetime')]
    private $dateExpires;

    public function __construct()
    {
        $this->token = (md5(microtime() . rand(100000, 10000000)));
        $this->dateExpires = (new \DateTime())->modify("+ 1 day");
        $this->status = DeviceStatus::ACTIVE;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getDateExpires(): ?\DateTimeInterface
    {
        return $this->dateExpires;
    }

    public function setDateExpires(\DateTimeInterface $dateExpires): self
    {
        $this->dateExpires = $dateExpires;

        return $this;
    }
}
