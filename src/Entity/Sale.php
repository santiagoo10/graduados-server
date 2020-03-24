<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put"},
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\SaleRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ApiFilter(SearchFilter::class, properties={"name":"partial"})
 * @ApiFilter(RangeFilter::class, properties={"price"})
 */
class Sale
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
     * @Groups({"user:read", "user:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Groups({"user:read", "user:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Groups({"user:read", "user:write"})
     */
    private $condition;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\PositiveOrZero
     * @Groups({"user:read", "user:write"})
     */
    private $price;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\PositiveOrZero
     * @Groups({"user:read", "user:write"})
     */
    private $discount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"user:read", "user:write"})
     */
    private $datePublication;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"user:read", "user:write"})
     */
    private $dateExpiration;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $revised;

    /**
     * @ORM\Column(type="datetime")
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"user:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"user:read"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="SaleType")
     * @Groups({"user:read", "user:write"})
     */
    private $saleType;

    /**
     * @ORM\ManyToOne(targetEntity="Store")
     * @Groups({"user:read", "user:write"})
     */
    private $store;

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


    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getDatePublication(): ?DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getDateExpiration(): ?DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(DateTimeInterface $dateExpiration): self
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getRevised(): ?bool
    {
        return $this->revised;
    }

    public function setRevised(bool $revised): self
    {
        $this->revised = $revised;

        return $this;
    }

    public function getCondition(): ?string
    {
        return $this->condition;
    }

    public function setCondition(?string $condition): self
    {
        $this->condition = $condition;

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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @throws Exception
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new DateTime();

        return $this;
    }

    public function getSaleType(): ?SaleType
    {
        return $this->saleType;
    }

    public function setSaleType(?SaleType $saleType): self
    {
        $this->saleType = $saleType;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }
}
