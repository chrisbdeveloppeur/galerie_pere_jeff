<?php

namespace App\Entity;

use App\Repository\OeuvreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OeuvreRepository::class)
 * @Vich\Uploadable
 */
class Oeuvre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="oeuvre", fileNameProperty="fileName")
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

    /**
     * @ORM\ManyToOne(targetEntity=YearDirectory::class, inversedBy="oeuvres", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="SET NULL");
     */
    private $year_directory;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $img_position;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;


    public function __construct()
    {
    }

    public function  __toString()
    {
        return $this->titre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
     * @return Oeuvre
     */
    public function setFileName(?string $fileName): Oeuvre
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getYearDirectory(): ?YearDirectory
    {
        return $this->year_directory;
    }

    public function setYearDirectory(?YearDirectory $year_directory): self
    {
        $this->year_directory = $year_directory;

        return $this;
    }

    public function getImgPosition(): ?int
    {
        return $this->img_position;
    }

    public function setImgPosition(?int $img_position): self
    {
        $this->img_position = $img_position;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }


}
