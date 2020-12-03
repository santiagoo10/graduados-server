<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use DateTime;
use DateTimeInterface;
use Exception;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     iri="http://schema.org/Address",
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "delete"={"method"="DELETE"} },
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"address:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"address:write"}, "swagger_definition_name"="Write"}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 * @ORM\HasLifecycleCallbacks
 * @ApiFilter(PropertyFilter::class)
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * Name.
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull ()
     * @Assert\Type("string")
     * @Groups({
     *     "address:read", "address:write",
     *     "academic_unit:read","academic_unit:write",
     *     "store:read", "store:write",
     *     "graduate:read", "graduate:write"
     * })
     * @ApiProperty(iri="http://schema.org/name")
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull ()
     * @Assert\Type("string")
     * @Groups({
     *     "address:read", "address:write",
     *     "store:read", "store:write",
     *     "academic_unit:read", "academic_unit:write",
     *     "graduate:read", "graduate:write"
     *     })
     */
    private string $street;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({
     *     "address:read", "address:write",
     *     "store:write", "store:read",
     *     "academic_unit:read", "academic_unit:write",
     *     "graduate:read", "graduate:write"
     *     })
     */
    private ?int $number;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({
     *     "address:read", "address:write"
     * })
     */
    private ?float $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"address:read", "address:write"})
     */
    private ?float $longitude;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({
     *     "address:read", "address:write",
     *     "store:write", "store:read",
     *     "academic_unit:read", "academic_unit:write",
     *     "graduate:read", "graduate:write"
     *     })
     * })
     */
    private ?string $phoneNumber;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"address:read"})
     */
    private ?DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"address:read"})
     */
    private ?DateTimeInterface $updatedAt;


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



    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

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

//    public function getZone(): ?Zone
//    {
//        return $this->zone;
//    }
//
//    public function setZone(?Zone $zone): self
//    {
//        $this->zone = $zone;
//
//        return $this;
//    }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


}
