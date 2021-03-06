<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TableauRepository")
 */
class Tableau
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
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projet", inversedBy="tableaux")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkProjet;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sprint", mappedBy="fkTableau")
     */
    private $sprints;


    public function __construct()
    {
        $this->sprints = new ArrayCollection();
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

    public function getFkProjet(): ?Projet
    {
        return $this->fkProjet;
    }

    public function setFkProjet(?Projet $fkProjet): self
    {
        $this->fkProjet = $fkProjet;

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
            $sprint->setFkTableau($this);
        }

        return $this;
    }

    public function removeSprint(Sprint $sprint): self
    {
        if ($this->sprints->contains($sprint)) {
            $this->sprints->removeElement($sprint);
            // set the owning side to null (unless already changed)
            if ($sprint->getFkTableau() === $this) {
                $sprint->setFkTableau(null);
            }
        }

        return $this;
    }

}
