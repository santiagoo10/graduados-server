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
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use App\Security\Role;
use App\Controller\ResetPasswordAction;

/**
 * @ApiResource(
 *     attributes={"security"="is_granted('ROLE_ADMIN')"},
 *     iri="http://schema.org/User",
 *     collectionOperations={"get"={"security"="is_granted('ROLE_ADMIN')"}, "post"},
 *     itemOperations={
 *      "get"={"security"="is_granted('ROLE_ADMIN')"},
 *      "put"={"security"="is_granted('ROLE_ADMIN')"},
 *      "put-reset-password"={
 *          "controller"=ResetPasswordAction::class,
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "method"="PUT",
 *          "path"="/users/{id}/reset-password",
 *          "denormalization_context"={"groups"={"put-reset-password"}}
 *       },
 *      "delete"={"method"="DELETE"}},
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}}
 * )
 *
 * @ApiFilter(BooleanFilter::class, properties={"isActive"})
 * @ApiFilter(SearchFilter::class, properties={"email":"partial", "username":"partial"})
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
 * })
 *
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups(
     *     {"admin:read", "store:read"}
     * )
     * @ApiProperty(iri="http://schema.org/identifier")
     */
    protected ?int $id;

    /**
     * Email from user.
     *
     * @ORM\Column(type="string", length=191, unique=true)
     * @Groups({
     *     "graduate:read", "graduate:write",
     *     "user:read", "user:write",
     *     "store:read",
     *     "admin:read", "admin:write",
     * })
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @ApiProperty(iri="http://schema.org/email")
     */
    protected ?string $email;

    /**
     * User's roles.
     *
     * @ORM\Column(type="json")
     * @Groups({"user:read", "user:write", "store:read"})
     */
    protected array $roles = [];

    /**
     * Date when the user has created.
     *
     * @ORM\Column(type="datetime")
     * @Groups({"user:read"})
     */
    protected ?DateTimeInterface $createdAt;

    /**
     * Date when the user has been updated.
     *
     * @ORM\Column(type="datetime")
     * @Groups({"user:read"})
     */
    protected ?DateTimeInterface $updatedAt;

    /**
     * User password.
     *
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=true)
     */
    protected string $password;

    /**
     * @var string The password
     * @Groups({"user:write", "admin:write", "graduate:write"})
     * @SerializedName("password")
     */
    protected string $plainPassword;

    /**
     * User new password
     * @var string|null User new password
     * @Groups({"put-reset-password"})
     *
     */
    private ?string $newPassword=null;

    /**
     * Old password
     *
     * @var string|null
     * @Groups({"put-reset-password"})
     */
    private ?string $oldPassword=null;


    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $passwordChangeDate=null;

    /**
     * User name.
     *
     * @ORM\Column(type="string", length=191, unique=true)
     * @Assert\Type("string")
     * @Groups({
     *     "user:read", "user:write",
     *     "store:read",
     *     "admin:read", "admin:write",
     *     "graduate:read", "graduate:write",
     *     })
     * @ApiProperty(iri="http://schema.org/name")
     */
    protected string $username;


    /**
     * @ORM\Column(type="boolean")
     * @Groups({
     *     "user:read", "user:write",
     *     "store:read",
     *     "admin:read", "admin:write",
     *     "graduate:read", "graduate:write",
     * })
     */
    protected bool $isActive = true;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $apiToken;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     *     "store:read",
     *     "user:read", "user:write",
     * })
     */
    protected ?string $idFirebase = null;


    public function __construct()
    {
        $this->roles[] = Role::ROLE_USER;
//        $this->oldPassword = $this->password;
    }

    /**
     * @return string|null
     */
    public function getIdFirebase(): ?string
    {
        return $this->idFirebase;
    }

    /**
     * @param string|null $idFirebase
     */
    public function setIdFirebase(?string $idFirebase): void
    {
        $this->idFirebase = $idFirebase;
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
        return (string)$this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = Role::ROLE_USER;

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
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt():void
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
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

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return User
     */
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    /**
     * @param string|null $newPassword
     */
    public function setNewPassword(?string $newPassword): void
    {
        $this->newPassword = $newPassword;
    }

    /**
     * @return string|null
     */
    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    /**
     * @param string|null $oldPassword
     */
    public function setOldPassword(?string $oldPassword): void
    {
        $this->oldPassword = $oldPassword;
    }

    /**
     * @return int|null
     */
    public function getPasswordChangeDate(): ?int
    {
        return $this->passwordChangeDate;
    }

    /**
     * @param int|null $passwordChangeDate
     */
    public function setPasswordChangeDate(?int $passwordChangeDate): void
    {
        $this->passwordChangeDate = $passwordChangeDate;
    }

}
