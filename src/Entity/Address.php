<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "delete"},
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"address:read"}},
 *     denormalizationContext={"groups"={"address:write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Groups({"address:read", "address:write", "person:read", "person:write"})
     */
    private $street;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"address:read", "address:write", "person:read", "person:write"})
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"address:read", "address:write", "person:read", "person:write"})
     */
    private $routeType;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"address:read", "address:write", "person:read", "person:write"})
     */
    private $routeNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"address:read", "address:write", "person:read", "person:write"})
     */
    private $km;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"address:read", "address:write"})
     */
    private $lat;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"address:read", "address:write"})
     */
    private $lon;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"address:read", "address:write" , "person:read", "person:write"})
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="datetime")
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"address:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"address:read"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Zone")
     * @Groups({"address:read", "address:write", "person:read", "person:write"})
     */
    private $zone;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Person", mappedBy="addresses")
     */
    private $people;

    public function __construct()
    {
        $this->people = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getRouteType(): ?string
    {
        return $this->routeType;
    }

    public function setRouteType(string $routeType): self
    {
        $this->routeType = $routeType;

        return $this;
    }

    public function getRouteNumber(): ?int
    {
        return $this->routeNumber;
    }

    public function setRouteNumber(int $routeNumber): self
    {
        $this->routeNumber = $routeNumber;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLon(): ?float
    {
        return $this->lon;
    }

    public function setLon(float $lon): self
    {
        $this->lon = $lon;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return $this
     * @throws Exception
     * @ORM\PrePersist()
     */
    public function setCreatedAt(): self
    {
        $this->createdAt = new DateTime();

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return $this
     * @throws Exception
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new DateTime();

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getPeople(): Collection
    {
        return $this->people;
    }

    public function addPerson(Person $person): self
    {
        if (!$this->people->contains($person)) {
            $this->people[] = $person;
            $person->addAddress($this);
        }

        return $this;
    }

    public function removePerson(Person $person): self
    {
        if ($this->people->contains($person)) {
            $this->people->removeElement($person);
            $person->removeAddress($this);
        }

        return $this;
    }


}
