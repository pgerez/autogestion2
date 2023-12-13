<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuditoriaCta
 *
 * @ORM\Table(name="auditoria_cta")
 * @ORM\Entity
 */
class AuditoriaCta
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
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=50, nullable=false)
     */
    private $usuario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="datetime", nullable=false)
     */
    private $hora;

    /**
     * @var string
     *
     * @ORM\Column(name="accion", type="string", length=5, nullable=false)
     */
    private $accion;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=50, nullable=false)
     */
    private $observacion;

    /**
     * @var int
     *
     * @ORM\Column(name="idfacturafk", type="integer", nullable=false)
     */
    private $idfacturafk;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?string
    {
        return $this->usuario;
    }

    public function setUsuario(string $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
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

    public function getAccion(): ?string
    {
        return $this->accion;
    }

    public function setAccion(string $accion): self
    {
        $this->accion = $accion;

        return $this;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(string $observacion): self
    {
        $this->observacion = $observacion;

        return $this;
    }

    public function getIdfacturafk(): ?int
    {
        return $this->idfacturafk;
    }

    public function setIdfacturafk(int $idfacturafk): self
    {
        $this->idfacturafk = $idfacturafk;

        return $this;
    }


}
