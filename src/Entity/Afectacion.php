<?php

namespace App\Entity;

use App\Repository\AfectacionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AfectacionRepository::class)
 */
class Afectacion
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tipo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observacion;

    /**
     * @ORM\ManyToOne(targetEntity=Hospital::class, inversedBy="afectacions")
     */
    private $hospital;

    /**
     * @ORM\ManyToOne(targetEntity=Proveedor::class, inversedBy="afectacion")
     */
    private $proveedor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImporte(): ?string
    {
        return $this->importe;
    }

    public function setImporte(?string $importe): self
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

    public function getTipo(): ?int
    {
        return $this->tipo;
    }

    public function setTipo(?int $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(?string $observacion): self
    {
        $this->observacion = $observacion;

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

    public function getProveedor(): ?Proveedor
    {
        return $this->proveedor;
    }

    public function setProveedor(?Proveedor $proveedor): self
    {
        $this->proveedor = $proveedor;

        return $this;
    }
}
