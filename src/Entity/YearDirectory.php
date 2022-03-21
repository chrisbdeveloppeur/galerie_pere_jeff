<?php

namespace App\Entity;

use App\Repository\YearDirectoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=YearDirectoryRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity(
 *     fields={"year"},
 *     message="Une galerie avec cette année existe déjà"
 * )
 */
class YearDirectory
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
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Oeuvre::class, mappedBy="year_directory")
     */
    private $oeuvres;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $year;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="year_directory_img", fileNameProperty="fileName")
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
     * @ORM\Column(type="integer")
     */
    private $year_start;

    /**
     * @ORM\Column(type="integer")
     */
    private $year_end;

    public function __construct()
    {
        $this->oeuvres = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getYear();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Oeuvre[]
     */
    public function getOeuvres(): Collection
    {
        return $this->oeuvres;
    }

    public function addOeuvre(Oeuvre $oeuvre): self
    {
        if (!$this->oeuvres->contains($oeuvre)) {
            $this->oeuvres[] = $oeuvre;
            $oeuvre->setYearDirectory($this);
        }

        return $this;
    }

    public function removeOeuvre(Oeuvre $oeuvre): self
    {
        if ($this->oeuvres->removeElement($oeuvre)) {
            // set the owning side to null (unless already changed)
            if ($oeuvre->getYearDirectory() === $this) {
                $oeuvre->setYearDirectory(null);
            }
        }

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(?string $year): self
    {
        $this->year = $year;

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
     * @return YearDirectory
     */
    public function setFileName(?string $fileName): YearDirectory
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getYearStart(): ?int
    {
        return $this->year_start;
    }

    public function setYearStart(int $year_start): self
    {
        $this->year_start = $year_start;

        return $this;
    }

    public function getYearEnd(): ?int
    {
        return $this->year_end;
    }

    public function setYearEnd(int $year_end): self
    {
        $this->year_end = $year_end;

        return $this;
    }
}
