<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 * @Vich\Uploadable()
 */
class Document
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @Vich\UploadableField(mapping="document", fileNameProperty="fileName", size="fileSize", mimeType="fileMimeType")
     * @Assert\File(
     *     mimeTypes={ "image/jpg", "image/png", "image/jpeg", "image/gif", "application/pdf" },
     *     maxSize="2M",
     *     mimeTypesMessage="Veuillez choisir un fichier de type .jpg, .jpeg, .png, .pdf ou .gif",
     *     maxSizeMessage="Veuillez choisir un fichier de 1.9Mo maximum"
     *  )
     */
    private $file;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $fileSize;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $fileMimeType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FileCategory", inversedBy="documents")
     */
    private $fileCategory;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFile(File $file = null)
    {
        $this->file = $file;

        if (null !== $file) {
            $this->updatedAt = new \DateTime();
        }
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function setFileSize(?int $fileSize): void
    {
        $this->fileSize = $fileSize;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function getFileMimeType(): ?string
    {
        return $this->fileMimeType;
    }

    public function setFileMimeType(?string $fileMimeType): void
    {
        $this->fileMimeType = $fileMimeType;
    }

    public function getFileCategory(): ?FileCategory
    {
        return $this->fileCategory;
    }

    public function setFileCategory(?FileCategory $fileCategory): self
    {
        $this->fileCategory = $fileCategory;

        return $this;
    }
}
