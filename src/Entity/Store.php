<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Security\Role;
use DateTimeInterface;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Address;


/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "delete"={"method"="DELETE"}},
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"store:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"store:write"}, "swagger_definition_name"= "Write"}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\StoreRepository")
 * @ApiFilter(SearchFilter::class, properties={"name":"partial" })
 * @ApiFilter(PropertyFilter::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Store
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * Name
     * @ORM\Column(type="string", length=255)
     * @Groups({"store:read", "store:write", "sale:read"})
     * @Assert\NotNull()
     *
     */
    private string $name;

    /**
     * Description
     * @ORM\Column(type="string", length=255)
     * @Groups({"store:read", "store:write", "sale:read"})
     * @Assert\NotNull()
     */
    private string $description;

    /**
     * Comertial email.
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(
     *     message = "The email '{{value}}' is not a valid email."
     * )
     * @Groups({"store:read", "store:write", "sale:read"})
     */
    private ?string $email;

    /**
     * Comertial phone
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"store:read", "store:write", "sale:read"})
     */
    private ?string $phone;


    /**
     * Date was created store.
     *
     * @ORM\Column(type="datetime")
     * @Groups({"store:read"})
     */
    private ?DateTimeInterface $createdAt;

    /**
     * Date was updated store.
     *
     * @ORM\Column(type="datetime")
     * @Groups({"store:read"})
     */
    private ?DateTimeInterface $updatedAt;

    /**
     * Store owner
     *
     * @ORM\ManyToMany(targetEntity=Owner::class, cascade={"persist"})
     * @Groups({"store:read", "store:write", "sale:read", "owner:read", "owner:write", "user:read", "user:write" })
     */
    private ?Collection $owner=null;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"store:read", "store:write", "address:read", "address:write", "zone:read"})
     */
    private ?Address $address=null;

    public function __construct()
    {
        $this->owner = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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


    /**
     * @return Collection|Owner[]
     */
    public function getOwner(): Collection
    {
        return $this->owner;
    }

    public function addOwner(Owner $owner): self
    {
        if (!$this->owner->contains($owner)) {
            $this->owner[] = $owner;
        }

        return $this;
    }

    public function removeOwner(Owner $owner): self
    {
        if ($this->owner->contains($owner)) {
            $this->owner->removeElement($owner);
        }
        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

}
