<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CitasRepository")
 */
class Citas
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="time")
     */
    private $hora;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_realizacion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuarios", inversedBy="cita")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Facturas", inversedBy="citas", cascade={"all"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $factura;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $descripcion;

    /**
     * Citas constructor.
     * @param $fecha_realizacion
     */
    public function __construct()
    {
        $this->fecha_realizacion = date_create(date('Y-m-d'));
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(\DateTimeInterface $hora): self
    {
        $this->hora = $hora;

        return $this;
    }

    public function getUser(): ?Usuarios
    {
        return $this->user;
    }

    public function setUser(?Usuarios $user): self
    {
        $this->user = $user;

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

    public function getFechaRealizacion(): ?\DateTimeInterface
    {
        return $this->fecha_realizacion;
    }

    public function setFechaRealizacion(\DateTimeInterface $fecha_realizacion): self
    {
        $this->fecha_realizacion = $fecha_realizacion;

        return $this;
    }

    public function getFactura(): ?Facturas
    {
        return $this->factura;
    }

    public function setFactura(Facturas $factura): self
    {
        $this->factura = $factura;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getId();
    }


}