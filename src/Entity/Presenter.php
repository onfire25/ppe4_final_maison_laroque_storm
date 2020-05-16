<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * Presenter
 *
 * @ORM\Table(name="presenter", indexes={@ORM\Index(name="id_1", columns={"id_image"}), @ORM\Index(name="id_2", columns={"id_produit"})})
 * @ORM\Entity(repositoryClass="App\Repository\PresenterRepository")
 */
class Presenter
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
     * @var \Image
     *
     * @ORM\ManyToOne(targetEntity="Image", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_image", referencedColumnName="id")
     * })
     */
    private $idImage;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_produit", referencedColumnName="id")
     * })
     */
    private $idProduit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdImage(): ?Image
    {
        return $this->idImage;
    }

    public function setIdImage(?Image $idImage): self
    {
        $this->idImage = $idImage;

        return $this;
    }

    public function getIdProduit(): ?Produit
    {
        return $this->idProduit;
    }

    public function setIdProduit(?Produit $idProduit): self
    {
        $this->idProduit = $idProduit;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->idProduit);
    }

}
