<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\CreateMediaObjectAction;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiResource(
 *     iri="http://schema.org/MediaObject",
 *     normalizationContext={
 *      "groups"={"media_object_read"}
 *     },
 *     collectionOperations={
 *      "post"={
 *          "controller"=CreateMediaObjectAction::class,
 *          "deserialize"=false,
 *          "validation_groups"={"Default", "media_object_create"},
 *          "openapi_context"={
 *              "requestBody"={
 *                  "content"={
 *                      "multipart/form-data"={
 *                          "schema"={
 *                              "type"="object",
 *                              "properties"={
 *                                  "file"={
 *                                      "type"="string",
 *                                      "format"="binary"
 *                                  }
 *                              }
 *                          }
 *                      }
 *                  }
 *              }
 *          },
 *      },
 *     "get"
 *     },
 *     itemOperations={"get"}
 * )
 * @Vich\Uploadable()
 * @ORM\Entity(repositoryClass="App\Repository\MediaObjectRepository")
 */
class MediaObject
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected ?int $id;

    /**
     * @var string|null
     *
     * @ApiProperty(iri="http://schema.org/contentUrl")
     * @Groups({"media_object_read"})
     */
    public ?string $contentUrl;

    /**
     * @var File|null
     *
     * @Assert\NotNull(groups={"media_object_create"})
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath")
     */
    public ?File $file;

    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     */
    public ?string $filePath;


    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     * @Groups({"media_object_read", "media_object_write"})
     */
    protected ?string $storeFirebase;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    /**
     * @return string|null
     */
    public function getStoreFirebase(): ?string
    {
        return $this->storeFirebase;
    }

    /**
     * @param string|null $storeFirebase
     */
    public function setStoreFirebase(?string $storeFirebase): void
    {
        $this->storeFirebase = $storeFirebase;
    }

    public function setFilePath(?string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }

}
