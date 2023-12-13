<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuenta
 *
 * @ORM\Table(name="cuenta")
 * @ORM\Entity
 */
class Cuenta
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
     * @ORM\Column(name="punto_vta", type="string", length=4, nullable=false)
     */
    private $puntoVta;

    /**
     * @var string
     *
     * @ORM\Column(name="factura", type="string", length=8, nullable=false)
     */
    private $factura;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", length=65535, nullable=false)
     */
    private $observacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_anexo", type="date", nullable=false)
     */
    private $fechaAnexo;

    /**
     * @var string
     *
     * @ORM\Column(name="debito", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $debito;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_estado", type="string", length=2, nullable=false)
     */
    private $codEstado;

    /**
     * @var string
     *
     * @ORM\Column(name="percibido", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $percibido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_cobro", type="date", nullable=false)
     */
    private $fechaCobro;

    /**
     * @var int
     *
     * @ORM\Column(name="recibo", type="integer", nullable=false)
     */
    private $recibo;

    /**
     * @var string
     *
     * @ORM\Column(name="liquidacion", type="string", length=50, nullable=false)
     */
    private $liquidacion;

    /**
     * @var string
     *
     * @ORM\Column(name="periodo_liq", type="string", length=11, nullable=false)
     */
    private $periodoLiq;

    /**
     * @var string
     *
     * @ORM\Column(name="cheque", type="string", length=15, nullable=false)
     */
    private $cheque;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_banco", type="string", length=2, nullable=false)
     */
    private $codBanco;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pres", type="date", nullable=false)
     */
    private $fechaPres;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vto", type="date", nullable=false)
     */
    private $fechaVto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="super", type="date", nullable=false)
     */
    private $super;

    /**
     * @var string
     *
     * @ORM\Column(name="saldo", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $saldo;

    /**
     * @var string
     *
     * @ORM\Column(name="neto", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $neto;

    /**
     * @var int
     *
     * @ORM\Column(name="estado", type="integer", nullable=false)
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_carga", type="date", nullable=false)
     */
    private $fechaCarga;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_carga", type="time", nullable=false)
     */
    private $horaCarga;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_carga", type="string", length=20, nullable=false)
     */
    private $usuarioCarga;

    /**
     * @var int
     *
     * @ORM\Column(name="id_factura_FK", type="integer", nullable=false)
     */
    private $idFacturaFk;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPuntoVta(): ?string
    {
        return $this->puntoVta;
    }

    public function setPuntoVta(string $puntoVta): self
    {
        $this->puntoVta = $puntoVta;

        return $this;
    }

    public function getFactura(): ?string
    {
        return $this->factura;
    }

    public function setFactura(string $factura): self
    {
        $this->factura = $factura;

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

    public function getFechaAnexo(): ?\DateTimeInterface
    {
        return $this->fechaAnexo;
    }

    public function setFechaAnexo(\DateTimeInterface $fechaAnexo): self
    {
        $this->fechaAnexo = $fechaAnexo;

        return $this;
    }

    public function getDebito(): ?string
    {
        return $this->debito;
    }

    public function setDebito(string $debito): self
    {
        $this->debito = $debito;

        return $this;
    }

    public function getCodEstado(): ?string
    {
        return $this->codEstado;
    }

    public function setCodEstado(string $codEstado): self
    {
        $this->codEstado = $codEstado;

        return $this;
    }

    public function getPercibido(): ?string
    {
        return $this->percibido;
    }

    public function setPercibido(string $percibido): self
    {
        $this->percibido = $percibido;

        return $this;
    }

    public function getFechaCobro(): ?\DateTimeInterface
    {
        return $this->fechaCobro;
    }

    public function setFechaCobro(\DateTimeInterface $fechaCobro): self
    {
        $this->fechaCobro = $fechaCobro;

        return $this;
    }

    public function getRecibo(): ?int
    {
        return $this->recibo;
    }

    public function setRecibo(int $recibo): self
    {
        $this->recibo = $recibo;

        return $this;
    }

    public function getLiquidacion(): ?string
    {
        return $this->liquidacion;
    }

    public function setLiquidacion(string $liquidacion): self
    {
        $this->liquidacion = $liquidacion;

        return $this;
    }

    public function getPeriodoLiq(): ?string
    {
        return $this->periodoLiq;
    }

    public function setPeriodoLiq(string $periodoLiq): self
    {
        $this->periodoLiq = $periodoLiq;

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

    public function getCodBanco(): ?string
    {
        return $this->codBanco;
    }

    public function setCodBanco(string $codBanco): self
    {
        $this->codBanco = $codBanco;

        return $this;
    }

    public function getFechaPres(): ?\DateTimeInterface
    {
        return $this->fechaPres;
    }

    public function setFechaPres(\DateTimeInterface $fechaPres): self
    {
        $this->fechaPres = $fechaPres;

        return $this;
    }

    public function getFechaVto(): ?\DateTimeInterface
    {
        return $this->fechaVto;
    }

    public function setFechaVto(\DateTimeInterface $fechaVto): self
    {
        $this->fechaVto = $fechaVto;

        return $this;
    }

    public function getSuper(): ?\DateTimeInterface
    {
        return $this->super;
    }

    public function setSuper(\DateTimeInterface $super): self
    {
        $this->super = $super;

        return $this;
    }

    public function getSaldo(): ?string
    {
        return $this->saldo;
    }

    public function setSaldo(string $saldo): self
    {
        $this->saldo = $saldo;

        return $this;
    }

    public function getNeto(): ?string
    {
        return $this->neto;
    }

    public function setNeto(string $neto): self
    {
        $this->neto = $neto;

        return $this;
    }

    public function getEstado(): ?int
    {
        return $this->estado;
    }

    public function setEstado(int $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getFechaCarga(): ?\DateTimeInterface
    {
        return $this->fechaCarga;
    }

    public function setFechaCarga(\DateTimeInterface $fechaCarga): self
    {
        $this->fechaCarga = $fechaCarga;

        return $this;
    }

    public function getHoraCarga(): ?\DateTimeInterface
    {
        return $this->horaCarga;
    }

    public function setHoraCarga(\DateTimeInterface $horaCarga): self
    {
        $this->horaCarga = $horaCarga;

        return $this;
    }

    public function getUsuarioCarga(): ?string
    {
        return $this->usuarioCarga;
    }

    public function setUsuarioCarga(string $usuarioCarga): self
    {
        $this->usuarioCarga = $usuarioCarga;

        return $this;
    }

    public function getIdFacturaFk(): ?int
    {
        return $this->idFacturaFk;
    }

    public function setIdFacturaFk(int $idFacturaFk): self
    {
        $this->idFacturaFk = $idFacturaFk;

        return $this;
    }


}
