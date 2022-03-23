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

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["show", "show_app"])]
    private $floorFrom;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["show", "show_app"])]
    private $floorTo;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["show", "show_app"])]
    private $builtFrom;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(["show", "show_app"])]
    private $builtTo;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["show", "show_app"])]
    private $typeBuilding;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["show", "show_app"])]
    private $entrance;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(["show", "show_app"])]
    private $furnitureAvailable;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(["show", "show_app"])]
    private $conditioner;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(["show", "show_app"])]
    private $heating;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(["show", "show_app"])]
    private $internet;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(["show", "show_app"])]
    private $kitchen;

    #[ORM\Column(type: 'boolean', nullable: true)]
    #[Groups(["show", "show_app"])]
    private $entrancePrivate;

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

    public function getFloorFrom(): ?int
    {
        return $this->floorFrom;
    }

    public function setFloorFrom(?int $floorFrom): self
    {
        $this->floorFrom = $floorFrom;

        return $this;
    }

    public function getFloorTo(): ?int
    {
        return $this->floorTo;
    }

    public function setFloorTo(?int $floorTo): self
    {
        $this->floorTo = $floorTo;

        return $this;
    }

    public function getBuiltFrom(): ?int
    {
        return $this->builtFrom;
    }

    public function setBuiltFrom(?int $builtFrom): self
    {
        $this->builtFrom = $builtFrom;

        return $this;
    }

    public function getBuiltTo(): ?int
    {
        return $this->builtTo;
    }

    public function setBuiltTo(?int $builtTo): self
    {
        $this->builtTo = $builtTo;

        return $this;
    }

    public function getTypeBuilding(): ?string
    {
        return $this->typeBuilding;
    }

    public function setTypeBuilding(?string $typeBuilding): self
    {
        $this->typeBuilding = $typeBuilding;

        return $this;
    }

    public function getEntrance(): ?string
    {
        return $this->entrance;
    }

    public function setEntrance(?string $entrance): self
    {
        $this->entrance = $entrance;

        return $this;
    }

    public function getFurnitureAvailable(): ?bool
    {
        return $this->furnitureAvailable;
    }

    public function setFurnitureAvailable(?bool $furnitureAvailable): self
    {
        $this->furnitureAvailable = $furnitureAvailable;

        return $this;
    }

    public function getConditioner(): ?bool
    {
        return $this->conditioner;
    }

    public function setConditioner(?bool $conditioner): self
    {
        $this->conditioner = $conditioner;

        return $this;
    }

    public function getHeating(): ?bool
    {
        return $this->heating;
    }

    public function setHeating(?bool $heating): self
    {
        $this->heating = $heating;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInternet()
    {
        return $this->internet;
    }

    /**
     * @param mixed $internet
     * @return Application
     */
    public function setInternet($internet)
    {
        $this->internet = $internet;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKitchen()
    {
        return $this->kitchen;
    }

    /**
     * @param mixed $kitchen
     * @return Application
     */
    public function setKitchen($kitchen)
    {
        $this->kitchen = $kitchen;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntrancePrivate()
    {
        return $this->entrancePrivate;
    }

    /**
     * @param mixed $entrancePrivate
     * @return Application
     */
    public function setEntrancePrivate($entrancePrivate)
    {
        $this->entrancePrivate = $entrancePrivate;
        return $this;
    }


}
