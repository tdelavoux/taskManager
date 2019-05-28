<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjetRepository")
 */
class Projet
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
     * @ORM\ManyToOne(targetEntity="App\Entity\user")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkOwner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tableau", mappedBy="fkProjet")
     */
    private $tableaux;

    public function __construct()
    {
        $this->tableaux = new ArrayCollection();
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

    public function getFkOwner(): ?user
    {
        return $this->fkOwner;
    }

    public function setFkOwner(?user $fkOwner): self
    {
        $this->fkOwner = $fkOwner;

        return $this;
    }

    /**
     * @return Collection|Tableau[]
     */
    public function getTableaux(): Collection
    {
        return $this->tableaux;
    }

    public function addTableaux(Tableau $tableaux): self
    {
        if (!$this->tableaux->contains($tableaux)) {
            $this->tableaux[] = $tableaux;
            $tableaux->setFkProjet($this);
        }

        return $this;
    }

    public function removeTableaux(Tableau $tableaux): self
    {
        if ($this->tableaux->contains($tableaux)) {
            $this->tableaux->removeElement($tableaux);
            // set the owning side to null (unless already changed)
            if ($tableaux->getFkProjet() === $this) {
                $tableaux->setFkProjet(null);
            }
        }

        return $this;
    }
}
