<?php

namespace App\Entity;

use App\Repository\CertificadoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Estado;

/**
 * @ORM\Entity(repositoryClass=CertificadoRepository::class)
 */
class Certificado
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_carga;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $monto;

    /**
     * @ORM\Column(type="integer")
     */
    private $punto_venta = 1;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @ORM\OneToMany(targetEntity=Factura::class, mappedBy="certificado")
     */
    private $facturas;

    /**
     *
     * @ORM\ManyToOne(targetEntity=ObrasSociales::class)
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="obrasocial_id", referencedColumnName="row_id")
     * })
     */
    private $obraSocial;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity=CertificadoFactura::class, mappedBy="certificados", cascade={"persist"})
     */
    private $certificadoFacturas;

    /**
     *
     * @ORM\ManyToOne(targetEntity=Hospital::class)
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="hospital_id", referencedColumnName="id")
     * })
     */
    private $hospital;




    public function __construct()
    {
        $this->facturas = new ArrayCollection();
        $this->certificadoFacturas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFechaCarga(): ?\DateTimeInterface
    {
        return $this->fecha_carga;
    }

    public function setFechaCarga(?\DateTimeInterface $fecha_carga): self
    {
        $this->fecha_carga = $fecha_carga;

        return $this;
    }
    

    public function getPuntoVenta(): ?int
    {
        return $this->punto_venta;
    }

    public function setPuntoVenta(int $punto_venta): self
    {
        $this->punto_venta = $punto_venta;

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

    public function getObraSocial(): ?ObrasSociales
    {
        return $this->obraSocial;
    }

    public function setObraSocial(?ObrasSociales $obraSocial): self
    {
        $this->obraSocial = $obraSocial;

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

    /**
     * @return Collection<int, CertificadoFactura>
     */
    public function getCertificadoFacturas(): Collection
    {
        return $this->certificadoFacturas;
    }

    public function addCertificadoFactura(CertificadoFactura $certificadoFactura): self
    {
        if (!$this->certificadoFacturas->contains($certificadoFactura)) {
            $this->certificadoFacturas[] = $certificadoFactura;
            $certificadoFactura->setCertificados($this);
        }

        return $this;
    }

    public function removeCertificadoFactura(CertificadoFactura $certificadoFactura): self
    {
        if ($this->certificadoFacturas->removeElement($certificadoFactura)) {
            // set the owning side to null (unless already changed)
            if ($certificadoFactura->getCertificados() === $this) {
                $certificadoFactura->setCertificados(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Factura>
     */
    public function getFacturas(): Collection
    {
        return $this->facturas;
    }

    public function addFactura(Factura $factura): self
    {
        if (!$this->facturas->contains($factura)) {
            $this->facturas[] = $factura;
            $factura->setCertificado($this);
        }

        return $this;
    }

    public function removeFactura(Factura $factura): self
    {
        global $kernel;
        if ( 'AppCache' == get_class($kernel) )
        {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get( 'doctrine.orm.entity_manager' );
        $e = $em->getRepository(Estado::class)->find(1);
        $du = $em->getRepository(Estado::class)->find(15);
        if ($this->facturas->removeElement($factura)) {
            // set the owning side to null (unless already changed)
            if ($factura->getCertificado() === $this) {
                $factura->setCertificado(null);
                $factura->getSaldo() == 0 ? $factura->setEstadoId($e) : $factura->setEstadoId($du);
            }
        }

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

    public function getHospital(): ?Hospital
    {
        return $this->hospital;
    }

    public function setHospital(?Hospital $hospital): self
    {
        $this->hospital = $hospital;

        return $this;
    }

}
