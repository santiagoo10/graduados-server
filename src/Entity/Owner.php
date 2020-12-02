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
class Owner
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

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



}
