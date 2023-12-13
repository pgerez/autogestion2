<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estimulo
 *
 * @ORM\Table(name="estimulo", indexes={@ORM\Index(name="hospital_id", columns={"hospital_id"}), @ORM\Index(name="liquidacion_id", columns={"liquidacion_id"}), @ORM\Index(name="recibo_id", columns={"recibo_id"})})
 * @ORM\Entity
 */
class Estimulo
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
     * @var string|null
     *
     * @ORM\Column(name="numero", type="string", length=45, nullable=true)
     */
    private $numero;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detalle", type="string", length=45, nullable=true)
     */
    private $detalle;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="estado", type="boolean", nullable=true)
     */
    private $estado;

    /**
     * @var int
     *
     * @ORM\Column(name="hospital_id", type="integer", nullable=false)
     */
    private $hospitalId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="pagado", type="boolean", nullable=true)
     */
    private $pagado;

    /**
     * @var float|null
     *
     * @ORM\Column(name="monto", type="float", precision=10, scale=0, nullable=true)
     */
    private $monto;

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
     * @var \Recibo
     *
     * @ORM\ManyToOne(targetEntity="Recibo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recibo_id", referencedColumnName="id")
     * })
     */
    private $recibo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;

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

    public function getEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(?bool $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getHospitalId(): ?int
    {
        return $this->hospitalId;
    }

    public function setHospitalId(int $hospitalId): self
    {
        $this->hospitalId = $hospitalId;

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

    public function getPagado(): ?bool
    {
        return $this->pagado;
    }

    public function setPagado(?bool $pagado): self
    {
        $this->pagado = $pagado;

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

    public function getLiquidacion(): ?Liquidacion
    {
        return $this->liquidacion;
    }

    public function setLiquidacion(?Liquidacion $liquidacion): self
    {
        $this->liquidacion = $liquidacion;

        return $this;
    }

    public function getRecibo(): ?Recibo
    {
        return $this->recibo;
    }

    public function setRecibo(?Recibo $recibo): self
    {
        $this->recibo = $recibo;

        return $this;
    }


}
