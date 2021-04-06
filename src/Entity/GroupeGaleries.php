<?php

namespace App\Entity;

use App\Repository\GroupeGaleriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupeGaleriesRepository::class)
 */
class GroupeGaleries
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
     * @ORM\OneToMany(targetEntity=Oeuvre::class, mappedBy="groupeGaleries")
     */
    private $Oeuvres;

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
        $this->Oeuvres = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
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
        return $this->Oeuvres;
    }

    public function addOeuvre(Oeuvre $oeuvre): self
    {
        if (!$this->Oeuvres->contains($oeuvre)) {
            $this->Oeuvres[] = $oeuvre;
            $oeuvre->setGroupeGaleries($this);
        }

        return $this;
    }

    public function removeOeuvre(Oeuvre $oeuvre): self
    {
        if ($this->Oeuvres->removeElement($oeuvre)) {
            // set the owning side to null (unless already changed)
            if ($oeuvre->getGroupeGaleries() === $this) {
                $oeuvre->setGroupeGaleries(null);
            }
        }

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
