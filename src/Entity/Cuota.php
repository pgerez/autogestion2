<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuota
 *
 * @ORM\Table(name="cuota", indexes={@ORM\Index(name="fk_cuota_pago1", columns={"pago_id"}), @ORM\Index(name="fk_cuota_tipopago1", columns={"tipopago_id"}), @ORM\Index(name="liquidacion_id", columns={"liquidacion_id"})})
 * @ORM\Entity
 */
class Cuota
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
     * @ORM\Column(name="fecha_pago", type="date", nullable=true)
     */
    private $fechaPago;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_liquidacion", type="date", nullable=true)
     */
    private $fechaLiquidacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero_comprobante", type="string", length=45, nullable=true)
     */
    private $numeroComprobante;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detalle", type="text", length=65535, nullable=true)
     */
    private $detalle;

    /**
     * @var float|null
     *
     * @ORM\Column(name="monto", type="float", precision=10, scale=0, nullable=true)
     */
    private $monto;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numero_cuota", type="integer", nullable=true)
     */
    private $numeroCuota;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observacion", type="text", length=65535, nullable=true)
     */
    private $observacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero_pago", type="string", length=45, nullable=true)
     */
    private $numeroPago;

    /**
     * @var \Liquidacion
     *
     * @ORM\ManyToOne(targetEntity="Liquidacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="liquidacion_id", referencedColumnName="id")
     * })
     */
    private $liquidacion;

    /**
     * @var \Pago
     *
     * @ORM\ManyToOne(targetEntity="Pago")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pago_id", referencedColumnName="id")
     * })
     */
    private $pago;

    /**
     * @var \Tipopago
     *
     * @ORM\ManyToOne(targetEntity="Tipopago")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipopago_id", referencedColumnName="id")
     * })
     */
    private $tipopago;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaPago(): ?\DateTimeInterface
    {
        return $this->fechaPago;
    }

    public function setFechaPago(?\DateTimeInterface $fechaPago): self
    {
        $this->fechaPago = $fechaPago;

        return $this;
    }

    public function getFechaLiquidacion(): ?\DateTimeInterface
    {
        return $this->fechaLiquidacion;
    }

    public function setFechaLiquidacion(?\DateTimeInterface $fechaLiquidacion): self
    {
        $this->fechaLiquidacion = $fechaLiquidacion;

        return $this;
    }

    public function getNumeroComprobante(): ?string
    {
        return $this->numeroComprobante;
    }

    public function setNumeroComprobante(?string $numeroComprobante): self
    {
        $this->numeroComprobante = $numeroComprobante;

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

    public function getMonto(): ?float
    {
        return $this->monto;
    }

    public function setMonto(?float $monto): self
    {
        $this->monto = $monto;

        return $this;
    }

    public function getNumeroCuota(): ?int
    {
        return $this->numeroCuota;
    }

    public function setNumeroCuota(?int $numeroCuota): self
    {
        $this->numeroCuota = $numeroCuota;

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

    public function getNumeroPago(): ?string
    {
        return $this->numeroPago;
    }

    public function setNumeroPago(?string $numeroPago): self
    {
        $this->numeroPago = $numeroPago;

        return $this;
    }

    public function getLiquidacion(): ?Liquidacion
    {
        return $this->liquidacion;
    }

    public function setLiquidacion(?Liquidacion $liquidacion): self
    {
        $this->liquidacion = $liquidacion;

        return $this;
    }

    public function getPago(): ?Pago
    {
        return $this->pago;
    }

    public function setPago(?Pago $pago): self
    {
        $this->pago = $pago;

        return $this;
    }

    public function getTipopago(): ?Tipopago
    {
        return $this->tipopago;
    }

    public function setTipopago(?Tipopago $tipopago): self
    {
        $this->tipopago = $tipopago;

        return $this;
    }


}
