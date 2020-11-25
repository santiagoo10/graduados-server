<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use DateTimeInterface;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={
 *      "get"={
 *          "normalization_context"={"groups"= {"country:read"}}} ,
 *      "put", "delete"={"method"="DELETE"}},
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"country:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"country:write"}, "swagger_definition_name"="Write"}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"code"})
 * @ApiFilter(SearchFilter::class, properties={"name":"partial"})
 */
class Country
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ApiProperty(identifier=true)
     */
    private int $id;

    /**
     * Country Code.
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Groups({"country:read", "country:write", "province:read"})
     */
    private string $code;


    /**
     * Complete name.
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Groups({"country:read", "country:write", "province:read"})
     * @ApiProperty(iri="http://schema.org/name")
     * @ApiProperty(identifier=true)
     */
    private string $name;

    /**
     * Date when the Country has been created.
     *
     * @ORM\Column(type="datetime")
     * @var DateTime A "Y-m-d H:i:s" formatted value
     * @Groups({"country:read"})
     */
    private DateTime $createdAt;

    /**
     * Date when the Country has been updated.
     *
     * @ORM\Column(type="datetime")
     * @var DateTime A "Y-m-d H:i:s" formatted value
     * @Groups({"country:read"})
     */
    private DateTime $updatedAt;


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

    /**
     * @return DateTimeInterface|null
     */
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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     *
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new DateTime();

        return $this;
    }

}
