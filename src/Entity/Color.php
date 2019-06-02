<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ColorRepository")
 */
class Color
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $hexa;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sprint", mappedBy="fkColor")
     */
    private $sprints;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Statut", mappedBy="fkColor")
     */
    private $statuts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Priorite", mappedBy="fkColor")
     */
    private $priorites;

    public function __construct()
    {
        $this->sprints = new ArrayCollection();
        $this->statuts = new ArrayCollection();
        $this->priorites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getHexa(): ?string
    {
        return $this->hexa;
    }

    public function setHexa(string $hexa): self
    {
        $this->hexa = $hexa;

        return $this;
    }

    /**
     * @return Collection|Sprint[]
     */
    public function getSprints(): Collection
    {
        return $this->sprints;
    }

    public function addSprint(Sprint $sprint): self
    {
        if (!$this->sprints->contains($sprint)) {
            $this->sprints[] = $sprint;
            $sprint->setFkColor($this);
        }

        return $this;
    }

    public function removeSprint(Sprint $sprint): self
    {
        if ($this->sprints->contains($sprint)) {
            $this->sprints->removeElement($sprint);
            // set the owning side to null (unless already changed)
            if ($sprint->getFkColor() === $this) {
                $sprint->setFkColor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Statut[]
     */
    public function getStatuts(): Collection
    {
        return $this->statuts;
    }

    public function addStatut(Statut $statut): self
    {
        if (!$this->statuts->contains($statut)) {
            $this->statuts[] = $statut;
            $statut->setFkColor($this);
        }

        return $this;
    }

    public function removeStatut(Statut $statut): self
    {
        if ($this->statuts->contains($statut)) {
            $this->statuts->removeElement($statut);
            // set the owning side to null (unless already changed)
            if ($statut->getFkColor() === $this) {
                $statut->setFkColor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Priorite[]
     */
    public function getPriorites(): Collection
    {
        return $this->priorites;
    }

    public function addPriorite(Priorite $priorite): self
    {
        if (!$this->priorites->contains($priorite)) {
            $this->priorites[] = $priorite;
            $priorite->setFkColor($this);
        }

        return $this;
    }

    public function removePriorite(Priorite $priorite): self
    {
        if ($this->priorites->contains($priorite)) {
            $this->priorites->removeElement($priorite);
            // set the owning side to null (unless already changed)
            if ($priorite->getFkColor() === $this) {
                $priorite->setFkColor(null);
            }
        }

        return $this;
    }
}
