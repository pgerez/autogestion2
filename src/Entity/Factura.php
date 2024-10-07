<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\ObrasSociales;
use App\Repository\FacturaRepository;

use Doctrine\ORM\Mapping as ORM;

/**
 * Factura
 *
 * @ORM\Table(name="factura", indexes={@ORM\Index(name="Cod_OS", columns={"Cod_OS"}), @ORM\Index(name="estado_id", columns={"estado_id"}), @ORM\Index(name="factura_id_factura", columns={"factura_id_factura"}), @ORM\Index(name="punto_venta", columns={"punto_venta"}), @ORM\Index(name="superintendencia_id", columns={"superintendencia_id"})})
 * @ORM\Entity(repositoryClass=FacturaRepository::class)
 */
class Factura
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_factura", type="integer", nullable=false, options={"comment"="identificador de  la tabla"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFactura;

    /**
     * @var string|null
     *
     * @ORM\Column(name="punto_venta", type="string", length=10, nullable=false)
     */
    private $puntoVenta = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="numero_factura", type="integer", nullable=false)
     */
    private $numeroFactura = '0';

    /**
     * @var \DateTime|null
     * 
     * @ORM\Column(name="fecha_emision", type="date", nullable=true)
     */
    private $fechaEmision = null;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="periodo", type="date", nullable=true)
     */
    private $periodo;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_facturacion", type="string", length=20, nullable=true)
     */
    private $usuarioFacturacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_factura", type="time", nullable=true)
     */
    private $horaFactura = null;

    /**
     * @var \ObrasSociales
     *
     * @ORM\ManyToOne(targetEntity="ObrasSociales")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Cod_OS", referencedColumnName="row_id")
     * })
     */
    private $codOs;

    /**
     * @var float
     *
     * @ORM\Column(name="Monto_Fact", type="float", precision=10, scale=0, nullable=false)
     */
    private $montoFact = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="monto_real", type="float", precision=10, scale=0, nullable=false)
     */
    private $montoReal;

    /**
     * @var int
     *
     * @ORM\Column(name="cod_EstadoFactura_FK", type="integer", nullable=false, options={"comment"="estado de vinculacion de la factura"})
     */
    private $codEstadofacturaFk = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Tipo_Fact", type="string", length=2, nullable=false, options={"fixed"=true})
     */
    private $tipoFact = '';

    /**
     * @var int|null
     *
     * @ORM\Column(name="estado_id", type="integer", nullable=true, options={"default"="1"})
     */
    /**
     * @var \Estado
     *
     * @ORM\ManyToOne(targetEntity="Estado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     * })
     */
    private $estadoId = 1;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_envio", type="date", nullable=true)
     */
    private $fechaEnvio;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_acuse", type="date", nullable=true)
     */
    private $fechaAcuse;

    /**
     * @var float|null
     *
     * @ORM\Column(name="debito", type="float", precision=10, scale=0, nullable=true)
     */
    private $debito;

    /**
     * @var int|null
     *
     * @ORM\Column(name="tipo_debito_id", type="integer", nullable=true)
     */
    private $tipoDebitoId;

    /**
     * @var \Hospital
     *
     * @ORM\ManyToOne(targetEntity="Hospital")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hospital_id", referencedColumnName="id")
     * })
     */
    private $hospitalId;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="carta_documento", type="boolean", nullable=true)
     */
    private $cartaDocumento;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_carta", type="date", nullable=true)
     */
    private $fechaCarta = null;

    /**
     * @var string|null
     *
     * @ORM\Column(name="digital_pv", type="string", length=4, nullable=true)
     */
    private $digitalPv;

    /**
     * @var int|null
     *
     * @ORM\Column(name="digital_num", type="integer", nullable=true)
     */
    private $digitalNum;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="digital_fecha", type="date", nullable=true)
     */
    private $digitalFecha;

    /**
     * @var float|null
     *
     * @ORM\Column(name="digital_monto", type="float", precision=10, scale=0, nullable=true)
     */
    private $digitalMonto;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_envio_super", type="date", nullable=true)
     */
    private $fechaEnvioSuper;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_fisc_estado", type="date", nullable=true)
     */
    private $fechaFiscEstado;

    /**
     * @var \Superintendencia
     *
     * @ORM\ManyToOne(targetEntity="Superintendencia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="superintendencia_id", referencedColumnName="id")
     * })
     */
    private $superintendencia;

    /**
     * @var \Factura
     *
     * @ORM\ManyToOne(targetEntity="Factura")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="factura_id_factura", referencedColumnName="id_factura")
     * })
     */
    private $facturaIdFactura;

    /**
     * @ORM\OneToMany(targetEntity=ItemPrefacturacion::class, mappedBy="id_factura_FK")
     */
    private $itemPrefacturacions;

    /**
     * @ORM\OneToMany(targetEntity=Factura::class, mappedBy="facturaIdFactura")
     */
    private $facturas;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cae;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codigo;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $cae_vto;

    /**
     * @ORM\Column(type="integer")
     */
    private $sistema = 1;

    /**
     *
     * @ORM\ManyToOne(targetEntity=Pago::class)
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="pago_id", referencedColumnName="id")
     * })
     */
    private $pago;

    /**
     *
     * @ORM\ManyToOne(targetEntity=Certificado::class)
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="certificado_id", referencedColumnName="id")
     * })
     */
    private $certificado;

    /**
     * @ORM\OneToMany(targetEntity=CertificadoFactura::class, mappedBy="facturas",cascade={"persist"})
     */
    private $certificadoFacturas;




    public function __toString()
    {
        return (string) $this->getNumeroCompleto();
    }
    public function __construct()
    {
        $this->setPeriodo(new \DateTime());
        $this->setDigitalFecha(new \DateTime());
        $this->setFechaEmision(new \DateTime());
        $this->setMontoReal(0);
        $this->setHoraFactura(new \DateTime());
        $this->setUsuarioFacturacion('SISTEMA');
        $this->itemPrefacturacions = new ArrayCollection();
        $this->certificadoFacturas = new ArrayCollection();
        $this->facturas = new ArrayCollection();
        

    }

    public function getNumeroCompleto()
    {
        $num = $this->getDigitalNum();
        $pv  = $this->getDigitalPv();
        $long  = strlen($num);
        $ceros = 8 - $long;
        for ($i=1 ; $i <= $ceros ; $i++ ){
            $num = '0'.$num;
        }
        $long  = strlen($pv);
        $ceros = 4 - $long;
        for ($i=1 ; $i <= $ceros ; $i++ ){
            $pv = '0'.$pv;
        }

        return (string) $pv.'-'.$num;
    }

    public function getAllFacturas()
    {
        $string = '';
        foreach ($this->facturas as $factura):
            $string .= '('.$factura->getEstadoId().') '.$factura.' | ';
        endforeach;
        return $string;
    }

    public function getSoloNumeroCompleto()
    {
        $num = $this->getDigitalNum();
        $long  = strlen($num);
        $ceros = 8 - $long;
        for ($i=1 ; $i <= $ceros ; $i++ ){
            $num = '0'.$num;
        }
        return (string) $num;
    }

    public function getSoloPvCompleto()
    {
        $pv  = $this->getDigitalPv();
        $long  = strlen($pv);
        $ceros = 4 - $long;
        for ($i=1 ; $i <= $ceros ; $i++ ){
            $pv = '0'.$pv;
        }
        return (string) $pv;
    }

    public function getIdFactura(): ?int
    {
        return $this->idFactura;
    }

    public function getPuntoVenta(): ?string
    {
        return $this->puntoVenta;
    }

    public function setPuntoVenta(string $puntoVenta): self
    {
        $this->puntoVenta = $puntoVenta;

        return $this;
    }

    public function getNumeroFactura(): ?int
    {
        return $this->numeroFactura;
    }

    public function setNumeroFactura(int $numeroFactura): self
    {
        $this->numeroFactura = $numeroFactura;

        return $this;
    }

    public function getFechaEmision(): ?\DateTimeInterface
    {
        return $this->fechaEmision;
    }

    public function setFechaEmision(?\DateTimeInterface $fechaEmision): self
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    public function getPeriodo(): ?\DateTimeInterface
    {
        return $this->periodo;
    }

    public function setPeriodo(?\DateTimeInterface $periodo): self
    {
        $this->periodo = $periodo;

        return $this;
    }

    public function getUsuarioFacturacion(): ?string
    {
        return $this->usuarioFacturacion;
    }

    public function setUsuarioFacturacion(?string $usuarioFacturacion): self
    {
        $this->usuarioFacturacion = $usuarioFacturacion;

        return $this;
    }

    public function getHoraFactura(): ?\DateTimeInterface
    {
        return $this->horaFactura;
    }

    public function setHoraFactura(?\DateTimeInterface $horaFactura): self
    {
        $this->horaFactura = $horaFactura;

        return $this;
    }

    public function getMontoFact(): ?float
    {
        return $this->montoFact;
    }

    public function setMontoFact(float $montoFact): self
    {
        $this->montoFact = $montoFact;

        return $this;
    }

    public function getMontoReal(): ?float
    {
        return $this->montoReal;
    }

    public function setMontoReal(float $montoReal): self
    {
        $this->montoReal = $montoReal;

        return $this;
    }

    public function getCodEstadofacturaFk(): ?int
    {
        return $this->codEstadofacturaFk;
    }

    public function setCodEstadofacturaFk(int $codEstadofacturaFk): self
    {
        $this->codEstadofacturaFk = $codEstadofacturaFk;

        return $this;
    }

    public function getTipoFact(): ?string
    {
        return $this->tipoFact;
    }

    public function setTipoFact(string $tipoFact): self
    {
        $this->tipoFact = $tipoFact;

        return $this;
    }

    public function getFechaEnvio(): ?\DateTimeInterface
    {
        return $this->fechaEnvio;
    }

    public function setFechaEnvio(?\DateTimeInterface $fechaEnvio): self
    {
        $this->fechaEnvio = $fechaEnvio;

        return $this;
    }

    public function getFechaAcuse(): ?\DateTimeInterface
    {
        return $this->fechaAcuse;
    }

    public function setFechaAcuse(?\DateTimeInterface $fechaAcuse): self
    {
        $this->fechaAcuse = $fechaAcuse;

        return $this;
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

    public function getTipoDebitoId(): ?int
    {
        return $this->tipoDebitoId;
    }

    public function setTipoDebitoId(?int $tipoDebitoId): self
    {
        $this->tipoDebitoId = $tipoDebitoId;

        return $this;
    }

    public function getCartaDocumento(): ?bool
    {
        return $this->cartaDocumento;
    }

    public function setCartaDocumento($cartaDocumento): self
    {
        $this->cartaDocumento = $cartaDocumento;

        return $this;
    }

    public function getFechaCarta(): ?\DateTimeInterface
    {
        return $this->fechaCarta;
    }

    public function setFechaCarta(?\DateTimeInterface $fechaCarta): self
    {
        $this->fechaCarta = $fechaCarta;

        return $this;
    }

    public function getDigitalPv(): ?string
    {
        return $this->digitalPv;
    }

    public function setDigitalPv($digitalPv): self
    {
        $this->digitalPv = $digitalPv;

        return $this;
    }

    public function getDigitalNum(): ?int
    {
        return $this->digitalNum;
    }

    public function setDigitalNum($digitalNum): self
    {
        $this->digitalNum = $digitalNum;

        return $this;
    }

    public function getDigitalFecha(): ?\DateTimeInterface
    {
        return $this->digitalFecha;
    }

    public function setDigitalFecha(?\DateTimeInterface $digitalFecha): self
    {
        $this->digitalFecha = $digitalFecha;

        return $this;
    }

    public function getDigitalMonto(): ?float
    {
        return $this->digitalMonto;
    }

    public function setDigitalMonto(?float $digitalMonto): self
    {
        $this->digitalMonto = $digitalMonto;

        return $this;
    }

    public function getFechaEnvioSuper(): ?\DateTimeInterface
    {
        return $this->fechaEnvioSuper;
    }

    public function setFechaEnvioSuper(?\DateTimeInterface $fechaEnvioSuper): self
    {
        $this->fechaEnvioSuper = $fechaEnvioSuper;

        return $this;
    }

    public function getFechaFiscEstado(): ?\DateTimeInterface
    {
        return $this->fechaFiscEstado;
    }

    public function setFechaFiscEstado(?\DateTimeInterface $fechaFiscEstado): self
    {
        $this->fechaFiscEstado = $fechaFiscEstado;

        return $this;
    }

    public function getHospitalId(): ?Hospital
    {
        return $this->hospitalId;
    }

    public function setHospitalId(?Hospital $hospitalId): self
    {
        $this->hospitalId = $hospitalId;

        return $this;
    }

    public function getSuperintendencia(): ?Superintendencia
    {
        return $this->superintendencia;
    }

    public function setSuperintendencia(?Superintendencia $superintendencia): self
    {
        $this->superintendencia = $superintendencia;

        return $this;
    }

    public function getFacturaIdFactura(): ?self
    {
        return $this->facturaIdFactura;
    }

    public function setFacturaIdFactura(?self $facturaIdFactura): self
    {
        $this->facturaIdFactura = $facturaIdFactura;

        return $this;
    }

    /**
     * @return Collection<int, ItemPrefacturacion>
     */
    public function getItemPrefacturacions(): Collection
    {
        return $this->itemPrefacturacions;
    }

    public function addItemPrefacturacion(ItemPrefacturacion $itemPrefacturacion): self
    {
        if (!$this->itemPrefacturacions->contains($itemPrefacturacion)) {
            $this->itemPrefacturacions[] = $itemPrefacturacion;
            $itemPrefacturacion->setIdFacturaFK($this);
        }

        return $this;
    }

    public function removeItemPrefacturacion(ItemPrefacturacion $itemPrefacturacion): self
    {
        if ($this->itemPrefacturacions->removeElement($itemPrefacturacion)) {
            // set the owning side to null (unless already changed)
            if ($itemPrefacturacion->getIdFacturaFK() === $this) {
                $itemPrefacturacion->setIdFacturaFK(null);
            }
        }

        return $this;
    }

    public function getCae(): ?string
    {
        return $this->cae;
    }

    public function setCae($cae): self
    {
        $this->cae = $cae;

        return $this;
    }

    public function getCodigo(): ?int
    {
        return $this->codigo;
    }

    public function setCodigo(?int $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getSistema(): ?int
    {
        return $this->sistema;
    }

    public function setSistema(int $sistema): self
    {
        $this->sistema = $sistema;

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

    public function getCodOs(): ?ObrasSociales
    {
        return $this->codOs;
    }

    public function setCodOs(?ObrasSociales $codOs): self
    {
        $this->codOs = $codOs;

        return $this;
    }

    public function getCertificado(): ?Certificado
    {
        return $this->certificado;
    }

    public function setCertificado(?Certificado $certificado): self
    {
        $this->certificado = $certificado;

        return $this;
    }

    public function getEstadoId(): ?Estado
    {
        return $this->estadoId;
    }

    public function setEstadoId(?Estado $estadoId): self
    {
        $this->estadoId = $estadoId;

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
            $certificadoFactura->setFacturas($this);
        }

        return $this;
    }

    public function removeCertificadoFactura(CertificadoFactura $certificadoFactura): self
    {
        if ($this->certificadoFacturas->removeElement($certificadoFactura)) {
            // set the owning side to null (unless already changed)
            if ($certificadoFactura->getFacturas() === $this) {
                $certificadoFactura->setFacturas(null);
            }
        }

        return $this;
    }

    public function getCaeVto(): ?\DateTimeInterface
    {
        return $this->cae_vto;
    }

    public function setCaeVto(?\DateTimeInterface $cae_vto): self
    {
        $this->cae_vto = $cae_vto;

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
            $factura->setIdFactura($this);
        }

        return $this;
    }

    public function removeFactura(Factura $factura): self
    {
        if ($this->facturas->removeElement($factura)) {
            // set the owning side to null (unless already changed)
            if ($factura->getIdFactura() === $this) {
                $factura->setIdFactura(null);
            }
        }

        return $this;
    }


}
