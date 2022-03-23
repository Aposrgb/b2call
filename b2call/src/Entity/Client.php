<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["show", "show_app"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["show", "show_app"])]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["show", "show_app"])]
    private $lastname;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["show", "show_app"])]
    private $patronymic;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["show", "show_app"])]
    private $mail;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["show", "show_app"])]
    private $phone;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Application::class)]
    #[Groups(["show"])]
    private $applications;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(string $patronymic): self
    {
        $this->patronymic = $patronymic;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone($phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->setClient($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getClient() === $this) {
                $application->setClient(null);
            }
        }

        return $this;
    }

}
