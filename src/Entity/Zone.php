<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={
 *      "get"={
 *          "normalization_context"={"groups":{"zone:read"}}
 *      },
 *      "put",
 *     "delete"={"method"="DELETE"}
 *     },
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"zone:read"}},
 *     denormalizationContext={"groups"={"zone:write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ZoneRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ApiFilter(SearchFilter::class, properties={"name":"partial"})
 */
class Zone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * Code.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Groups({"zone:read", "zone:write", "address:read", "academic_unit:read", "store:read"})
     */
    private string $code;

    /**
     * Name.
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull ()
     * @Assert\Type("string")
     * @Groups({"zone:read", "zone:write", "address:read", "academic_unit:read", "store:read"})
     * @ApiProperty(iri="http://schema.org/name")
     * @ApiFilter(SearchFilter::class, strategy="partial")
     *
     */
    private string $name;

    /**
     * Type
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Groups({"zone:read", "zone:write", "address:read", "academic_unit:read", "store:read"})
     */
    private string $type;

    /**
     * Date when the zone has been updated.
     *
     * @ORM\Column(type="datetime")
     * @Groups({"zone:read"})
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"zone:read"})
     */
    private DateTime $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="City")
     * @Groups({"zone:read", "zone:write", "address:read", "academic_unit:read", "store:read"})
     */
    private City $city;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
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

    public function getUpdatedAt(): ?\DateTimeInterface
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

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }


}
