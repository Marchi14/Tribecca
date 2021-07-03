<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FacturasRepository")
 */
class Facturas
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DetallesFactura", mappedBy="factura")
     */
    private $detalles;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Citas", mappedBy="factura", cascade={"persist", "remove"})
     */
    private $citas;

    /**
     * @ORM\Column(type="float")
     */
    private $importe_total;

    public function __construct()
    {
        $this->detalles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $detalle->setDServicio($this);
        }

        return $this;
    }

    public function removeDetalle(DetallesFactura $detalle): self
    {
        if ($this->detalles->contains($detalle)) {
            $this->detalles->removeElement($detalle);
            // set the owning side to null (unless already changed)
            if ($detalle->getDServicio() === $this) {
                $detalle->setDServicio(null);
            }
        }

        return $this;
    }

    public function getCitas(): ?Citas
    {
        return $this->citas;
    }

    public function setCitas(Citas $citas): self
    {
        $this->citas = $citas;

        // set the owning side of the relation if necessary
        if ($citas->getFactura() !== $this) {
            $citas->setFactura($this);
        }

        return $this;
    }

    public function getImporteTotal(): ?float
    {
        return $this->importe_total;
    }

    public function setImporteTotal(float $importe_total): self
    {
        $this->importe_total = $importe_total;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getId();
    }


}
