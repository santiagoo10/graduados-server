<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     iri="http://schema.org/Province",
 *     attributes={"security"="is_granted('ROLE_ADMIN')"},
 *     collectionOperations={"get"={"security"="is_granted('ROLE_ADMIN')"}, "post"},
 *     itemOperations={
 *      "get"={
 *          "normalization_context"={"groups"= {"province:read"}}},
 *     "put", "delete"={"method"="DELETE"}},
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"province:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"province:write"}, "swagger_definition_name"="Write"}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProvinceRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ApiFilter(SearchFilter::class, properties={"name":"partial"})
 */
class Province
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * Province code.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"province:read", "province:write", "city:read"})
     *
     */
    private ?string $code;

    /**
     * Name.
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Groups({"province:read", "province:write", "city:read"})
     * @ApiProperty(iri="http://schema.org/name")
     */
    private ?string $name;

    /**
     * Abbreviation.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Groups({"province:read", "province:write", "city:read"})
     */
    private ?string $abbreviation;

    /**
     * Date when the Province has been created.
     *
     * @ORM\Column(type="datetime")
     * @var DateTime A "Y-m-d H:i:s" formatted value
     * @Groups({"province:read"})
     */
    private DateTime $createdAt;

    /**
     * Date when the Province has been updated.
     *
     * @ORM\Column(type="datetime")
     * @var DateTime A "Y-m-d H:i:s" formatted value
     * @Groups({"province:read"})
     */
    private DateTime $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Country")
     * @Assert\Valid()
     * @Groups({"province:read", "province:write" , "city:read"})
     *
     */
    private ?Country $country;



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

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): self
    {
        $this->abbreviation = $abbreviation;

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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new DateTime();

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

}
