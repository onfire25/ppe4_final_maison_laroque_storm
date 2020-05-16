<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resider
 *
 * @ORM\Table(name="resider", indexes={@ORM\Index(name="id_2", columns={"id_adresse"}), @ORM\Index(name="id_1", columns={"id_user"})})
 * @ORM\Entity(repositoryClass="App\Repository\ResiderRepository")
 */
class Resider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    /**
     * @var \Adresse
     *
     * @ORM\ManyToOne(targetEntity="Adresse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_adresse", referencedColumnName="id")
     * })
     */
    private $idAdresse;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \User
     */
    public function getIdUser(): \User
    {
        return $this->idUser;
    }

    /**
     * @param \User $idUser
     */
    public function setIdUser(\User $idUser): void
    {
        $this->idUser = $idUser;
    }


    public function getIdAdresse(): ?Adresse
    {
        return $this->idAdresse;
    }

    public function setIdAdresse(?Adresse $idAdresse): self
    {
        $this->idAdresse = $idAdresse;

        return $this;
    }


}
