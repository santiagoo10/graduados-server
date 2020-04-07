<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put",  "delete"={"method"="DELETE"}},
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"academic_unit:read"}},
 *     denormalizationContext={"groups"={"academic_unit:write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\AcademicUnitRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ApiFilter(SearchFilter::class, properties={"name":"partial"})
 */
class AcademicUnit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Name of the academic unit or institute.
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Groups({"academic_unit:read", "academic_unit:write", "profession:read"})
     */
    private $name;

    /**
     * Phone of the atention to informatic personal.
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Groups({"academic_unit:read", "academic_unit:write", "profession:read"})
     */
    private $phone;

    /**
     * Emmail for technical support.
     *
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @Groups({"academic_unit:read", "academic_unit:write", "profession:read"})
     */
    private $email;

    /**
     * Date when the Unit academic has been created in the sistem.
     *
     * @ORM\Column(type="datetime")
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"academic_unit:read", "profession:read"})
     */
    private $createdAt;

    /**
     * Date when Unit academic has been updated in the sistem.
     *
     * @ORM\Column(type="datetime")
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"academic_unit:read", "profession:read"})
     */
    private $updatedAt;

    /**
     * Contact person for technical supports.
     *
     * @ORM\ManyToOne(targetEntity="Person", cascade={"persist"})
     * @ORM\JoinColumn(name="contacto_id", referencedColumnName="id")
     * @Groups({"academic_unit:read", "academic_unit:write", "profession:read"})
     * @Assert\Valid()
     */
    private $contact;

    /**
     * Addres of the Unit academic.
     *
     * @ORM\ManyToOne(targetEntity="Address", cascade={"persist"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     * @Groups({"academic_unit:read", "academic_unit:write", "profession:read"})
     * @Assert\Valid()
     */
    private $address;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
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


    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

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

    public function getContact(): ?Person
    {
        return $this->contact;
    }

    public function setContact(?Person $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
