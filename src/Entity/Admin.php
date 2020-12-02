<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Security\Role;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ApiResource(
 *
 *     iri="http://schema.org/Admin",
 *     collectionOperations={
 *      "get" = {
 *          },
 *      "post"
 *      },
 *     itemOperations={"get", "put", "delete"={"method"="DELETE"}},
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"admin:read"}},
 *     denormalizationContext={"groups"={"admin:write"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"cuit":"partial"})
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 * @UniqueEntity(fields={"dni"})
 * @UniqueEntity(fields={"cuit"})
 */
class Admin extends User
{

    /**
     * Names
     *
     * @ORM\Column(type="string", length=255)
     * @Groups({"admin:read", "admin:write"})
     */
    private $name;

    /**
     * Lastnames
     *
     * @ORM\Column(type="string", length=255)
     * @Groups({"admin:read", "admin:write"})
     */
    private $lastName;

    /**
     * Documento Nacional de Identidad Argentino
     *
     * @ORM\Column(type="string", length=255)
     * @Groups({"admin:read", "admin:write"})
     */
    private $dni;

    /**
     * Código Unico Argentino
     *
     * @ORM\Column(type="string", length=255)
     * @ApiProperty(iri="http://schema.org/name")
     * @Groups({"admin:read", "admin:write"})
     * @Assert\Length(
     *      min = 8,
     *      max = 11,
     *      minMessage = "Your cuit must be at least 7 characters long",
     *      maxMessage = "Your cuit cannot be longer than 9 characters",
     *      allowEmptyString = false
     * )
     * @Assert\Regex(
     *     pattern="/\s/",
     *     match=false,
     *     message="Your cuit cannot contain a string"
     * )
     * @Assert\Type(type={"numeric"})
     */
    private $cuit;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"admin:read", "admin:write"})
     */
    private $cellPhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"admin:read", "admin:write"})
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"admin:read", "admin:write"})
     */
    private $job;

    public function __construct()
    {
        parent::__construct();
        $this->roles[] = Role::ROLE_ADMIN;
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getCuit(): ?string
    {
        return $this->cuit;
    }

    public function setCuit(string $cuit): self
    {
        $this->cuit = $cuit;

        return $this;
    }

    public function getCellPhone(): ?string
    {
        return $this->cellPhone;
    }

    public function setCellPhone(string $cellPhone): self
    {
        $this->cellPhone = $cellPhone;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(?string $job): self
    {
        $this->job = $job;

        return $this;
    }
}
