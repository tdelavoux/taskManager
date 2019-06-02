<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TacheRepository")
 */
class Tache
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $deadline;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sprint", inversedBy="taches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkSprint;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="taches")
     */
    private $fkUser;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Statut", inversedBy="taches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkStatut;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Priorite", inversedBy="taches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fkPriorite;

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

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getFkSprint(): ?Sprint
    {
        return $this->fkSprint;
    }

    public function setFkSprint(?Sprint $fkSprint): self
    {
        $this->fkSprint = $fkSprint;

        return $this;
    }

    public function getFkUser(): ?User
    {
        return $this->fkUser;
    }

    public function setFkUser(?User $fkUser): self
    {
        $this->fkUser = $fkUser;

        return $this;
    }

    public function getFkStatut(): ?Statut
    {
        return $this->fkStatut;
    }

    public function setFkStatut(?Statut $fkStatut): self
    {
        $this->fkStatut = $fkStatut;

        return $this;
    }

    public function getFkPriorite(): ?Priorite
    {
        return $this->fkPriorite;
    }

    public function setFkPriorite(?Priorite $fkPriorite): self
    {
        $this->fkPriorite = $fkPriorite;

        return $this;
    }
}
