<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pago
 *
 * @ORM\Table(name="pago", indexes={@ORM\Index(name="FI_pago_obras_sociales2", columns={"obras_sociales_cod_os"}), @ORM\Index(name="fk_pago_sf_guard_user1", columns={"sf_guard_user_id"}), @ORM\Index(name="hospital_id", columns={"hospital_id"})})
 * @ORM\Entity
 */
class Pago
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
     * @var float|null
     *
     * @ORM\Column(name="debito", type="float", precision=10, scale=0, nullable=true)
     */
    private $debito;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observacion", type="text", length=65535, nullable=true)
     */
    private $observacion;

    /**
     * @var int
     *
     * @ORM\Column(name="obras_sociales_cod_os", type="integer", nullable=false)
     */
    private $obrasSocialesCodOs;

    /**
     * @var int
     *
     * @ORM\Column(name="sf_guard_user_id", type="integer", nullable=false)
     */
    private $sfGuardUserId;

    /**
     * @var float|null
     *
     * @ORM\Column(name="monto", type="float", precision=10, scale=0, nullable=true)
     */
    private $monto;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_super_intendencia", type="boolean", nullable=true)
     */
    private $isSuperIntendencia;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="nota_credito", type="boolean", nullable=true)
     */
    private $notaCredito;

    /**
     * @var int|null
     *
     * @ORM\Column(name="hospital_id", type="integer", nullable=true)
     */
    private $hospitalId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="text", length=65535, nullable=true)
     */
    private $descripcion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebito(): ?float
    {
        return $this->debito;
    }

    public function setDebito(?float $debito): self
    {
        $this->debito = $debito;

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

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(?int $cantidad): self
    {
        $this->cantidad = $cantidad;

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

    public function getObrasSocialesCodOs(): ?int
    {
        return $this->obrasSocialesCodOs;
    }

    public function setObrasSocialesCodOs(int $obrasSocialesCodOs): self
    {
        $this->obrasSocialesCodOs = $obrasSocialesCodOs;

        return $this;
    }

    public function getSfGuardUserId(): ?int
    {
        return $this->sfGuardUserId;
    }

    public function setSfGuardUserId(int $sfGuardUserId): self
    {
        $this->sfGuardUserId = $sfGuardUserId;

        return $this;
    }

    public function getMonto(): ?float
    {
        return $this->monto;
    }

    public function setMonto(?float $monto): self
    {
        $this->monto = $monto;

        return $this;
    }

    public function getIsSuperIntendencia(): ?bool
    {
        return $this->isSuperIntendencia;
    }

    public function setIsSuperIntendencia(?bool $isSuperIntendencia): self
    {
        $this->isSuperIntendencia = $isSuperIntendencia;

        return $this;
    }

    public function getNotaCredito(): ?bool
    {
        return $this->notaCredito;
    }

    public function setNotaCredito(?bool $notaCredito): self
    {
        $this->notaCredito = $notaCredito;

        return $this;
    }

    public function getHospitalId(): ?int
    {
        return $this->hospitalId;
    }

    public function setHospitalId(?int $hospitalId): self
    {
        $this->hospitalId = $hospitalId;

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


}
