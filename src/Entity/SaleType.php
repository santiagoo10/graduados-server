<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "delete"={"method"="DELETE"}},
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"sale_type:read"}},
 *     denormalizationContext={"groups"={"sale_type:write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\SaleTypeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ApiFilter(SearchFilter::class, properties={"name":"partial"})
 */
class SaleType
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
     * @Groups({"sale_type:read", "sale_type:write", "sale:read"})
     * @ApiProperty(iri="http://schema.org/name")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Groups({"sale_type:read", "sale_type:write", "sale:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"sale_type:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"sale_type:read"})
     */
    private $updatedAt;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"sale_type:read", "sale_type:write", "sale:read"})
     */
    public $image;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new DateTime();

        return $this;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(?MediaObject $image): self
    {
        $this->image = $image;

        return $this;
    }
}
