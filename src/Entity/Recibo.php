<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recibo
 *
 * @ORM\Table(name="recibo", indexes={@ORM\Index(name="cuota_id", columns={"cuota_id"}), @ORM\Index(name="sf_guard_user_id", columns={"sf_guard_user_id"})})
 * @ORM\Entity
 */
class Recibo
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
     * @ORM\Column(name="pto_vta", type="string", length=45, nullable=false)
     */
    private $ptoVta;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer", nullable=false)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="cheque", type="string", length=100, nullable=false)
     */
    private $cheque;

    /**
     * @var float
     *
     * @ORM\Column(name="monto", type="float", precision=10, scale=0, nullable=false, options={"comment"="95,5%"})
     */
    private $monto;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_emicion", type="datetime", nullable=true)
     */
    private $fechaEmicion;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_cobro", type="datetime", nullable=true)
     */
    private $fechaCobro;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observacion", type="text", length=65535, nullable=true)
     */
    private $observacion;

    /**
     * @var float
     *
     * @ORM\Column(name="monto_foresu", type="float", precision=10, scale=0, nullable=false)
     */
    private $montoForesu;

    /**
     * @var float|null
     *
     * @ORM\Column(name="monto_iosep", type="float", precision=10, scale=0, nullable=true)
     */
    private $montoIosep;

    /**
     * @var string
     *
     * @ORM\Column(name="cheque_anses", type="string", length=100, nullable=false)
     */
    private $chequeAnses;

    /**
     * @var float|null
     *
     * @ORM\Column(name="monto_anses", type="float", precision=10, scale=0, nullable=true)
     */
    private $montoAnses;

    /**
     * @var string
     *
     * @ORM\Column(name="expediente", type="string", length=100, nullable=false)
     */
    private $expediente;

    /**
     * @var string
     *
     * @ORM\Column(name="orden_pago", type="string", length=100, nullable=false)
     */
    private $ordenPago;

    /**
     * @var \Cuota
     *
     * @ORM\ManyToOne(targetEntity="Cuota")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cuota_id", referencedColumnName="id")
     * })
     */
    private $cuota;

    /**
     * @var \SfGuardUser
     *
     * @ORM\ManyToOne(targetEntity="SfGuardUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sf_guard_user_id", referencedColumnName="id")
     * })
     */
    private $sfGuardUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPtoVta(): ?string
    {
        return $this->ptoVta;
    }

    public function setPtoVta(string $ptoVta): self
    {
        $this->ptoVta = $ptoVta;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getCheque(): ?string
    {
        return $this->cheque;
    }

    public function setCheque(string $cheque): self
    {
        $this->cheque = $cheque;

        return $this;
    }

    public function getMonto(): ?float
    {
        return $this->monto;
    }

    public function setMonto(float $monto): self
    {
        $this->monto = $monto;

        return $this;
    }

    public function getFechaEmicion(): ?\DateTimeInterface
    {
        return $this->fechaEmicion;
    }

    public function setFechaEmicion(?\DateTimeInterface $fechaEmicion): self
    {
        $this->fechaEmicion = $fechaEmicion;

        return $this;
    }

    public function getFechaCobro(): ?\DateTimeInterface
    {
        return $this->fechaCobro;
    }

    public function setFechaCobro(?\DateTimeInterface $fechaCobro): self
    {
        $this->fechaCobro = $fechaCobro;

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

    public function getMontoForesu(): ?float
    {
        return $this->montoForesu;
    }

    public function setMontoForesu(float $montoForesu): self
    {
        $this->montoForesu = $montoForesu;

        return $this;
    }

    public function getMontoIosep(): ?float
    {
        return $this->montoIosep;
    }

    public function setMontoIosep(?float $montoIosep): self
    {
        $this->montoIosep = $montoIosep;

        return $this;
    }

    public function getChequeAnses(): ?string
    {
        return $this->chequeAnses;
    }

    public function setChequeAnses(string $chequeAnses): self
    {
        $this->chequeAnses = $chequeAnses;

        return $this;
    }

    public function getMontoAnses(): ?float
    {
        return $this->montoAnses;
    }

    public function setMontoAnses(?float $montoAnses): self
    {
        $this->montoAnses = $montoAnses;

        return $this;
    }

    public function getExpediente(): ?string
    {
        return $this->expediente;
    }

    public function setExpediente(string $expediente): self
    {
        $this->expediente = $expediente;

        return $this;
    }

    public function getOrdenPago(): ?string
    {
        return $this->ordenPago;
    }

    public function setOrdenPago(string $ordenPago): self
    {
        $this->ordenPago = $ordenPago;

        return $this;
    }

    public function getCuota(): ?Cuota
    {
        return $this->cuota;
    }

    public function setCuota(?Cuota $cuota): self
    {
        $this->cuota = $cuota;

        return $this;
    }

    public function getSfGuardUser(): ?SfGuardUser
    {
        return $this->sfGuardUser;
    }

    public function setSfGuardUser(?SfGuardUser $sfGuardUser): self
    {
        $this->sfGuardUser = $sfGuardUser;

        return $this;
    }


}
