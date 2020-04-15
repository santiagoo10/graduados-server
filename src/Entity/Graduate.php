<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use App\Security\Role;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={
 *      "get"={
 *          "normalization_context"={
 *              "groups"={"graduate:read"}
 *          }},
 *      "put", "delete"={"method"="DELETE"} },
 *     attributes={ "pagination_per_page"= 10},
 *     normalizationContext={"groups"={"graduate:read"}},
 *     denormalizationContext={"groups"={"graduate:write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\GraduateRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Graduate extends User
{

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $work;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $position;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $continueStuding;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $interest;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $wantToLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $agreementType;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $wantToUnderTake;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $comment;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $showEmail;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({ "graduate:read", "graduate:write"})
     * @ORM\Column(type="datetime")
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $bornDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $personalSite;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Profession")
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $professions;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $dni;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $cuit;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $cellPhone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address")
     * @Groups({ "graduate:read", "graduate:write"})
     */
    private $address;

    public function __construct()
    {
        parent::__construct();
        $this->professions = new ArrayCollection();
        $this->roles[]= Role::ROLE_GRADUATE;
    }


    public function getWork(): ?string
    {
        return $this->work;
    }

    public function setWork(?string $work): self
    {
        $this->work = $work;

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

    public function getContinueStuding(): ?bool
    {
        return $this->continueStuding;
    }

    public function setContinueStuding(?bool $continueStuding): self
    {
        $this->continueStuding = $continueStuding;

        return $this;
    }

    public function getInterest(): ?string
    {
        return $this->interest;
    }

    public function setInterest(?string $interest): self
    {
        $this->interest = $interest;

        return $this;
    }

    public function getWantToLink(): ?bool
    {
        return $this->wantToLink;
    }

    public function setWantToLink(?bool $wantToLink): self
    {
        $this->wantToLink = $wantToLink;

        return $this;
    }

    public function getAgreementType(): ?string
    {
        return $this->agreementType;
    }

    public function setAgreementType(?string $agreementType): self
    {
        $this->agreementType = $agreementType;

        return $this;
    }

    public function getWantToUnderTake(): ?bool
    {
        return $this->wantToUnderTake;
    }

    public function setWantToUnderTake(?bool $wantToUnderTake): self
    {
        $this->wantToUnderTake = $wantToUnderTake;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getShowEmail(): ?bool
    {
        return $this->showEmail;
    }

    public function setShowEmail(?bool $showEmail): self
    {
        $this->showEmail = $showEmail;

        return $this;
    }

    public function getBornDate(): ?DateTimeInterface
    {
        return $this->bornDate;
    }

    public function setBornDate(?DateTimeInterface $bornDate): self
    {
        $this->bornDate = $bornDate;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getPersonalSite(): ?string
    {
        return $this->personalSite;
    }

    public function setPersonalSite(?string $personalSite): self
    {
        $this->personalSite = $personalSite;

        return $this;
    }

    /**
     * @return Collection|Profession[]
     */
    public function getProfessions(): Collection
    {
        return $this->professions;
    }

    public function addProfession(Profession $profession): self
    {
        if (!$this->professions->contains($profession)) {
            $this->professions[] = $profession;
        }

        return $this;
    }

    public function removeProfession(Profession $profession): self
    {
        if ($this->professions->contains($profession)) {
            $this->professions->removeElement($profession);
        }

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

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }



}
