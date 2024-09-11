<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LiquidacionRepository;
use Doctrine\ORM\Repository;
use Doctrine\ORM\EntityManager;

/**
 * Liquidacion
 *
 * @ORM\Table(name="liquidacion", indexes={@ORM\Index(name="hospital_id", columns={"hospital_id"}), @ORM\Index(name="obras_sociales_row_id", columns={"obras_sociales_row_id"})})
 * @ORM\Entity(repositoryClass=LiquidacionRepository::class)
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

    /**
     * @ORM\OneToMany(targetEntity=Cuota::class, mappedBy="liquidacion")
     */
    private $cuotas;

    /**
     * @var \Hospital
     *
     * @ORM\ManyToOne(targetEntity="Hospital")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hospital_id", referencedColumnName="id")
     * })
     */
    private $hospital;

    /**
     * @var \ObrasSociales
     *
     * @ORM\ManyToOne(targetEntity="ObrasSociales")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="obras_sociales_row_id", referencedColumnName="row_id")
     * })
     */
    private $obrasocial;

    /**
     * @ORM\OneToMany(targetEntity=Estimulo::class, mappedBy="liquidacion")
     */
    private $estimulos;

    public function __construct()
    {
        $this->cuotas = new ArrayCollection();
        $this->estimulos = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getFechaDesde()->format('d-m-Y').' | '.$this->getFechaHasta()->format('d-m-Y');
    }

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

    /**
     * @return Collection<int, Cuenta>
     */
    public function getCuotas(): Collection
    {
        return $this->cuotas;
    }

    public function addCuota(Cuenta $cuota): self
    {
        if (!$this->cuotas->contains($cuota)) {
            $this->cuotas[] = $cuota;
            $cuota->setLiquidacion($this);
        }

        return $this;
    }

    public function removeCuota(Cuenta $cuota): self
    {
        if ($this->cuotas->removeElement($cuota)) {
            // set the owning side to null (unless already changed)
            if ($cuota->getLiquidacion() === $this) {
                $cuota->setLiquidacion(null);
            }
        }

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

    public function getObrasocial(): ?ObrasSociales
    {
        return $this->obrasocial;
    }

    public function setObrasocial(?ObrasSociales $obrasocial): self
    {
        $this->obrasocial = $obrasocial;

        return $this;
    }

    /**
     * @return Collection<int, Estimulo>
     */
    public function getEstimulos(): Collection
    {
        return $this->estimulos;
    }

    public function addEstimulo(Estimulo $estimulo): self
    {
        if (!$this->estimulos->contains($estimulo)) {
            $this->estimulos[] = $estimulo;
            $estimulo->setLiquidacion($this);
        }

        return $this;
    }

    public function removeEstimulo(Estimulo $estimulo): self
    {
        if ($this->estimulos->removeElement($estimulo)) {
            // set the owning side to null (unless already changed)
            if ($estimulo->getLiquidacion() === $this) {
                $estimulo->setLiquidacion(null);
            }
        }

        return $this;
    }




}
