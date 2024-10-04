<?php

namespace App\Entity;

use App\Repository\IncrementoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IncrementoRepository::class)
 */
class Incremento
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $importe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numero_expediente;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity=Hospital::class, inversedBy="incrementos")
     */
    private $hospital;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detalle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImporte(): ?string
    {
        return $this->importe;
    }

    public function setImporte($importe): self
    {
        $this->importe = $importe;

        return $this;
    }

    public function getNumeroExpediente(): ?string
    {
        return $this->numero_expediente;
    }

    public function setNumeroExpediente(?string $numero_expediente): self
    {
        $this->numero_expediente = $numero_expediente;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getTipo(): ?bool
    {
        return $this->tipo;
    }

    public function setTipo(?bool $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getHospital(): ?Hospital
    {
        return $this->hospital;
    }

    public function setHospital(?Hospital $hospital): self
    {
        $this->hospital = $hospital;

        return $this;
    }

    public function getDetalle(): ?string
    {
        return $this->detalle;
    }

    public function setDetalle(?string $detalle): self
    {
        $this->detalle = $detalle;

        return $this;
    }
}
