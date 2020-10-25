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

/**
 *  * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "delete"={"method"="DELETE"}},
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"owner:read"}},
 *     denormalizationContext={"groups"={"owner:write"}}
 * )
 *
 * @ApiFilter(PropertyFilter::class)
 * @ApiFilter(SearchFilter::class, properties={"cuit":"partial"})
 * @ORM\Entity(repositoryClass="App\Repository\OwnerRepository")
 * @UniqueEntity(fields={"dni"})
 * @UniqueEntity(fields={"cuit"})
 */
class Owner extends User
{

    /**
     * Names
     *
     * @Groups({
     *     "owner:read", "owner:write",
     *     "store:read", "store:write"
     * })
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * LastNames
     *
     * @Groups({
     *     "owner:read", "owner:write",
     *     "store:read", "store:write"
     * })
     *
     * @ORM\Column(type="string", length=255)
     */
    private ?string $lastName;

    /**
     * Documento Nacional de Identidad Argentino
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({
     *     "owner:read", "owner:write",
     *     "store:read", "store:write"
     * })
     */
    private ?string $dni;

    /**
     * Código Unico Argentino
     *
     * @ORM\Column(type="string", length=255)
     * @ApiProperty(iri="http://schema.org/name")
     *
     * @Groups({
     *     "owner:read", "owner:write",
     *     "store:read", "store:write"
     * })
     */
    private ?string $cuit;

    /**
     * Cell phone
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({
     *     "owner:read", "owner:write",
     *     "store:read", "store:write"
     * })
     */
    private ?string $cellPhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $uidFirebase;
    


    public function __construct()
    {
        parent::__construct();

        $this->roles[] = Role::ROLE_OWNER;
    }

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

    public function getUidFirebase(): ?string
    {
        return $this->uidFirebase;
    }

    public function setUidFirebase(?string $uidFirebase): self
    {
        $this->uidFirebase = $uidFirebase;

        return $this;
    }
}
