<?php

namespace App\Entity;

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
}
