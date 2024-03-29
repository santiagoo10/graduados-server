<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateTime;
use Exception;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     attributes={"security"="is_granted('ROLE_ADMIN')"},
 *     iri="http://schema.org/Prefession",
 *     collectionOperations={"get"={"security"="is_granted('ROLE_ADMIN')"}, "post"},
 *     itemOperations={"get", "put", "delete"={"method"="DELETE"}},
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"profession:read"}},
 *     denormalizationContext={"groups"={"profession:write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProfessionRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ApiFilter(SearchFilter::class, properties={"name":"partial"})
 */
class Profession
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Name
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Groups({"profession:read", "profession:write"})
     * @ApiProperty(iri="http://schema.org/name")
     */
    private $name;

    /**
     * Degree
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Groups({"profession:read", "profession:write"})
     */
    private $type;

    /**
     * Date when the Profession has been created in the sistem.
     *
     * @ORM\Column(type="datetime")
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"profession:read"})
     */
    private $createdAt;

    /**
     * Date when the Profession has been updated in the sistem.
     *
     * @ORM\Column(type="datetime")
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"profession:read"})
     */
    private $updatedAt;

    /**
     * Unidad académica
     *
     * @ORM\ManyToOne(targetEntity="AcademicUnit")
     * @ORM\JoinColumn(name="academic_unit_id", referencedColumnName="id")
     * @Groups({"profession:read", "profession:write"})
     */
    private $academicUnit;


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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAcademicUnit(): ?AcademicUnit
    {
        return $this->academicUnit;
    }

    public function setAcademicUnit(?AcademicUnit $academicUnit): self
    {
        $this->academicUnit = $academicUnit;

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
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     * @throws Exception
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new DateTime();

        return $this;
    }
}
