<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ItemPrefacturacionRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ItemPrefacturacion
 *
 * @ORM\Table(name="item_prefacturacion", indexes={@ORM\Index(name="Cod_NHPGD", columns={"id_nomenclador_FK"}), @ORM\Index(name="id_factura_FK", columns={"id_factura_FK"}), @ORM\Index(name="Num_Anexo", columns={"Num_Anexo"})})
 * @ORM\Entity(repositoryClass=ItemPrefacturacionRepository::class)
 */
class ItemPrefacturacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @var int
     * @Assert\GreaterThan(0)
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private $cantidad = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="string", length=10, nullable=true)
     */
    private $precio = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="reparto", type="float", precision=10, scale=0, nullable=false)
     */
    private $reparto = '0';


  #   /**
  #   * @var \Factura
  #   *
  #   * @ORM\ManyToOne(targetEntity="Factura")
  ##   * @ORM\JoinColumns({
  #   *   @ORM\JoinColumn(name="id_factura_FK", referencedColumnName="itemFacturas")
  #   * })
  #   */
  #  private $idFacturaFk;

    /**
     * @var int
     *
     * @ORM\Column(name="estado_factura", type="integer", nullable=false)
     */
    private $estadoFactura;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="estado_pago", type="boolean", nullable=true)
     */
    private $estadoPago = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="estado_item", type="boolean", nullable=true)
     */
    private $estadoItem = '0';

    /**
     * @var float|null
     *
     * @ORM\Column(name="monto_pago", type="float", precision=10, scale=0, nullable=true)
     */
    private $montoPago = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="cuota_id", type="integer", nullable=true)
     */
    private $cuotaId = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="codserv_FKM", type="string", length=10, nullable=true, options={"fixed"=true})
     */
    private $codservFkm;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado_debito", type="boolean", nullable=false)
     */
    private $estadoDebito;

     /**
     * @var \Factura
     *
     * @ORM\ManyToOne(targetEntity="Factura",cascade={"persist"}, inversedBy="itemPrefacturacions" )
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_factura_FK", referencedColumnName="id_factura")
     * })
     */
    private $id_factura_FK;


    /**
     * @ORM\ManyToOne(targetEntity=Servicios::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codserv_FK", referencedColumnName="codserv")
     * })
     */
    private $codserv_FK;

    /**
     * @ORM\ManyToOne(targetEntity=Anexoii::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Num_Anexo", referencedColumnName="Num_Anexo")
     * })
     */
    private $Num_Anexo;

    /**
     * @ORM\ManyToOne(targetEntity=Nomencla::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_nomenclador_FK", referencedColumnName="row_id")
     * })
     */
    private $nomencla;


    public function __construct()
    {
        $this->setEstadoFactura(1);
        $this->setEstadoDebito(0);
    }

    public function __toString()
    {
        return (string)$this->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(string $precio)
    {
        $this->precio = $precio;

        return $this;
    }

    public function getReparto(): ?float
    {
        return $this->reparto;
    }

    public function setReparto(float $reparto): self
    {
        $this->reparto = $reparto;

        return $this;
    }

    public function getEstadoFactura(): ?int
    {
        return $this->estadoFactura;
    }

    public function setEstadoFactura(int $estadoFactura): self
    {
        $this->estadoFactura = $estadoFactura;

        return $this;
    }

    public function getEstadoPago(): ?bool
    {
        return $this->estadoPago;
    }

    public function setEstadoPago( $estadoPago): self
    {
        $this->estadoPago = $estadoPago;

        return $this;
    }

    public function getEstadoItem(): ?bool
    {
        return $this->estadoItem;
    }

    public function setEstadoItem( $estadoItem): self
    {
        $this->estadoItem = $estadoItem;

        return $this;
    }

    public function getMontoPago(): ?float
    {
        return $this->montoPago;
    }

    public function setMontoPago(?float $montoPago): self
    {
        $this->montoPago = $montoPago;

        return $this;
    }

    public function getCuotaId(): ?int
    {
        return $this->cuotaId;
    }

    public function setCuotaId(?int $cuotaId): self
    {
        $this->cuotaId = $cuotaId;

        return $this;
    }

    public function getCodservFkm(): ?string
    {
        return $this->codservFkm;
    }

    public function setCodservFkm(?string $codservFkm): self
    {
        $this->codservFkm = $codservFkm;

        return $this;
    }

    public function getEstadoDebito(): ?bool
    {
        return $this->estadoDebito;
    }

    public function setEstadoDebito( $estadoDebito): self
    {
        $this->estadoDebito = $estadoDebito;

        return $this;
    }

    public function getIdFacturaFK(): ?Factura
    {
        return $this->id_factura_FK;
    }

    public function setIdFacturaFK(?Factura $id_factura_FK): self
    {
        $this->id_factura_FK = $id_factura_FK;

        return $this;
    }

    public function getCodservFK(): ?Servicios
    {
        return $this->codserv_FK;
    }

    public function setCodservFK(?Servicios $codserv_FK): self
    {
        $this->codserv_FK = $codserv_FK;

        return $this;
    }

    public function getNumAnexo(): ?Anexoii
    {
        return $this->Num_Anexo;
    }

    public function setNumAnexo(?Anexoii $Num_Anexo): self
    {
        $this->Num_Anexo = $Num_Anexo;

        return $this;
    }

    public function getNomencla(): ?Nomencla
    {
        return $this->nomencla;
    }

    public function setNomencla(?Nomencla $nomencla): self
    {
        $this->nomencla = $nomencla;

        return $this;
    }




    
        
    
}
