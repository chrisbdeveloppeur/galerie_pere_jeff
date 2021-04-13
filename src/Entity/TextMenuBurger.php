<?php

namespace App\Entity;

use App\Repository\TextMenuBurgerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TextMenuBurgerRepository::class)
 * @Vich\Uploadable
 */
class TextMenuBurger
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="bio_img", fileNameProperty="fileName")
     * @Assert\File(
     *     maxSize = "40M",
     *     mimeTypes = {"image/bmp", "image/png", "image/svg+xml", "image/jpx", "image/jpg", "image/jpeg"},
     *     mimeTypesMessage = "Seul les formats suivant sont acceptés : jpeg/png/svg/bmp"
     * )
     */
    private $file;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fileName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }


    public function setFile(?File $file = null): void
    {
        $this->file = $file;
        if ($this->file instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return string|null
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * @param string|null $fileName
     * @return TextMenuBurger
     */
    public function setFileName(?string $fileName): TextMenuBurger
    {
        $this->fileName = $fileName;
        return $this;
    }
}
