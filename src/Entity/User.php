<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateTime;
use DateTimeInterface;
use Exception;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use App\Security\Role;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put"},
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}}
 * )
 *
 * @ApiFilter(BooleanFilter::class, properties={"isActive"})
 * @ApiFilter(SearchFilter::class, properties={"email":"partial"})
 * @ApiFilter(PropertyFilter::class)
 * @UniqueEntity(fields={"username"})
 * @UniqueEntity(fields={"email"})
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "graduate" = "Graduate",
 *     "user"="User",
 *     "admin"="Admin",
 *     "owner"="Owner"
 * })
 *
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * Email from user.
     *
     * @ORM\Column(type="string", length=191, unique=true)
     * @Groups({
     *     "graduate:read", "graduate:write",
     *     "user:read", "user:write",
     *     "store:read", "store:write",
     *     "admin:read", "admin:write",
     *     "owner:read", "owner:write"
     * })
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    protected $email;

    /**
     * User's roles.
     *
     * @ORM\Column(type="json")
     */
    protected $roles = [];

    /**
     * Date when the user has created.
     *
     * @ORM\Column(type="datetime")
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"user:read"})
     */
    protected $createdAt;

    /**
     * Date when the user has been updated.
     *
     * @ORM\Column(type="datetime")
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"user:read"})
     */
    protected $updatedAt;

    /**
     * User password.
     *
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user:write", "admin:write", "graduate:write", "owner:write", "store:write"})
     */
    protected $password;

    /**
     * User name.
     *
     * @ORM\Column(type="string", length=191, unique=true)
     * @Assert\Type("string")
     * @Groups({
     *     "user:read", "user:write",
     *     "store:read", "store:write",
     *     "admin:read", "admin:write",
     *     "graduate:read", "graduate:write",
     *     "owner:read", "owner:write"
     *     })
     * @ApiProperty(iri="http://schema.org/name")
     */
    protected $username;


    /**
     * @ORM\Column(type="boolean")
     * @Groups({
     *     "user:read", "user:write",
     *     "store:read", "store:write",
     *     "admin:read", "admin:write",
     *     "graduate:read", "graduate:write",
     *     "owner:read", "owner:write"
     * })
     */
    protected $isActive = true;


    public function __construct()
    {

//        $this->id = Uuid::uuid4()->toString();
        $this->roles[] = Role::ROLE_USER;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }



}
