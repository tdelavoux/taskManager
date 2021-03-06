<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SprintRepository")
 */
class Sprint
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Color", inversedBy="sprints")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkColor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tableau", inversedBy="sprints")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkTableau;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tache", mappedBy="fkSprint")
     */
    private $taches;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
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

    public function getFkColor(): ?Color
    {
        return $this->fkColor;
    }

    public function setFkColor(?Color $fkColor): self
    {
        $this->fkColor = $fkColor;

        return $this;
    }

    public function getFkTableau(): ?Tableau
    {
        return $this->fkTableau;
    }

    public function setFkTableau(?Tableau $fkTableau): self
    {
        $this->fkTableau = $fkTableau;

        return $this;
    }

    /**
     * @return Collection|Tache[]
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Tache $tach): self
    {
        if (!$this->taches->contains($tach)) {
            $this->taches[] = $tach;
            $tach->setFkSprint($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): self
    {
        if ($this->taches->contains($tach)) {
            $this->taches->removeElement($tach);
            // set the owning side to null (unless already changed)
            if ($tach->getFkSprint() === $this) {
                $tach->setFkSprint(null);
            }
        }

        return $this;
    }

}
