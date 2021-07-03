<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiciosRepository")
 */
class Servicios
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
    private $nombre;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DetallesFactura", mappedBy="servicio")
     */
    private $detalles;

    public function __construct()
    {
        $this->detalles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * @return Collection|DetallesFactura[]
     */
    public function getDetalles(): Collection
    {
        return $this->detalles;
    }

    public function addDetalle(DetallesFactura $detalle): self
    {
        if (!$this->detalles->contains($detalle)) {
            $this->detalles[] = $detalle;
            $detalle->setServicio($this);
        }

        return $this;
    }

    public function removeDetalle(DetallesFactura $detalle): self
    {
        if ($this->detalles->contains($detalle)) {
            $this->detalles->removeElement($detalle);
            // set the owning side to null (unless already changed)
            if ($detalle->getServicio() === $this) {
                $detalle->setServicio(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getNombre();
    }


}
