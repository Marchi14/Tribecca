<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DetallesFacturaRepository")
 */
class DetallesFactura
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Facturas", inversedBy="detalles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $factura;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Servicios", inversedBy="detalles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $servicio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFactura(): ?Facturas
    {
        return $this->factura;
    }

    public function setFactura(?Facturas $factura): self
    {
        $this->factura = $factura;

        return $this;
    }

    public function getServicio(): ?Servicios
    {
        return $this->servicio;
    }

    public function setServicio(?Servicios $servicio): self
    {
        $this->servicio = $servicio;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getId();
    }


}
