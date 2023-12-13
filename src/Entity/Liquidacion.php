<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Liquidacion
 *
 * @ORM\Table(name="liquidacion", indexes={@ORM\Index(name="hospital_id", columns={"hospital_id"}), @ORM\Index(name="obras_sociales_row_id", columns={"obras_sociales_row_id"})})
 * @ORM\Entity
 */
class Liquidacion
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_desde", type="date", nullable=true)
     */
    private $fechaDesde;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_hasta", type="date", nullable=true)
     */
    private $fechaHasta;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observacion", type="text", length=65535, nullable=true)
     */
    private $observacion;

    /**
     * @var int|null
     *
     * @ORM\Column(name="obras_sociales_row_id", type="integer", nullable=true)
     */
    private $obrasSocialesRowId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="hospital_id", type="integer", nullable=true)
     */
    private $hospitalId;

    /**
     * @var bool
     *
     * @ORM\Column(name="acreditar", type="boolean", nullable=false)
     */
    private $acreditar;

    /**
     * @var int|null
     *
     * @ORM\Column(name="expediente_num", type="integer", nullable=true)
     */
    private $expedienteNum;

    /**
     * @var int|null
     *
     * @ORM\Column(name="expediente_cod", type="integer", nullable=true)
     */
    private $expedienteCod;

    /**
     * @var int|null
     *
     * @ORM\Column(name="expediente_anio", type="integer", nullable=true)
     */
    private $expedienteAnio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaDesde(): ?\DateTimeInterface
    {
        return $this->fechaDesde;
    }

    public function setFechaDesde(?\DateTimeInterface $fechaDesde): self
    {
        $this->fechaDesde = $fechaDesde;

        return $this;
    }

    public function getFechaHasta(): ?\DateTimeInterface
    {
        return $this->fechaHasta;
    }

    public function setFechaHasta(?\DateTimeInterface $fechaHasta): self
    {
        $this->fechaHasta = $fechaHasta;

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

    public function getObrasSocialesRowId(): ?int
    {
        return $this->obrasSocialesRowId;
    }

    public function setObrasSocialesRowId(?int $obrasSocialesRowId): self
    {
        $this->obrasSocialesRowId = $obrasSocialesRowId;

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

    public function getAcreditar(): ?bool
    {
        return $this->acreditar;
    }

    public function setAcreditar(bool $acreditar): self
    {
        $this->acreditar = $acreditar;

        return $this;
    }

    public function getExpedienteNum(): ?int
    {
        return $this->expedienteNum;
    }

    public function setExpedienteNum(?int $expedienteNum): self
    {
        $this->expedienteNum = $expedienteNum;

        return $this;
    }

    public function getExpedienteCod(): ?int
    {
        return $this->expedienteCod;
    }

    public function setExpedienteCod(?int $expedienteCod): self
    {
        $this->expedienteCod = $expedienteCod;

        return $this;
    }

    public function getExpedienteAnio(): ?int
    {
        return $this->expedienteAnio;
    }

    public function setExpedienteAnio(?int $expedienteAnio): self
    {
        $this->expedienteAnio = $expedienteAnio;

        return $this;
    }


}
