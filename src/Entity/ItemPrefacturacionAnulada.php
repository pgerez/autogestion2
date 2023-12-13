<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemPrefacturacionAnulada
 *
 * @ORM\Table(name="item_prefacturacion_anulada", indexes={@ORM\Index(name="Cod_NHPGD", columns={"id_nomenclador_FK"}), @ORM\Index(name="id_factura_FK", columns={"id_factura_FK"}), @ORM\Index(name="Num_Anexo", columns={"Num_Anexo"})})
 * @ORM\Entity
 */
class ItemPrefacturacionAnulada
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
     *
     * @ORM\Column(name="Num_Anexo", type="integer", nullable=false)
     */
    private $numAnexo = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="codserv_FK", type="string", length=10, nullable=false, options={"fixed"=true,"comment"="cod de vinculacion con los servicios"})
     */
    private $codservFk;

    /**
     * @var int
     *
     * @ORM\Column(name="id_nomenclador_FK", type="integer", nullable=false)
     */
    private $idNomencladorFk = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private $cantidad = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="string", length=10, nullable=false)
     */
    private $precio;

    /**
     * @var float
     *
     * @ORM\Column(name="reparto", type="float", precision=10, scale=0, nullable=false)
     */
    private $reparto = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="id_factura_FK", type="integer", nullable=false, options={"comment"="id de vinculacion con la factura"})
     */
    private $idFacturaFk = '0';

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumAnexo(): ?int
    {
        return $this->numAnexo;
    }

    public function setNumAnexo(int $numAnexo): self
    {
        $this->numAnexo = $numAnexo;

        return $this;
    }

    public function getCodservFk(): ?string
    {
        return $this->codservFk;
    }

    public function setCodservFk(string $codservFk): self
    {
        $this->codservFk = $codservFk;

        return $this;
    }

    public function getIdNomencladorFk(): ?int
    {
        return $this->idNomencladorFk;
    }

    public function setIdNomencladorFk(int $idNomencladorFk): self
    {
        $this->idNomencladorFk = $idNomencladorFk;

        return $this;
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

    public function setPrecio(string $precio): self
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

    public function getIdFacturaFk(): ?int
    {
        return $this->idFacturaFk;
    }

    public function setIdFacturaFk(int $idFacturaFk): self
    {
        $this->idFacturaFk = $idFacturaFk;

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

    public function setEstadoPago(?bool $estadoPago): self
    {
        $this->estadoPago = $estadoPago;

        return $this;
    }

    public function getEstadoItem(): ?bool
    {
        return $this->estadoItem;
    }

    public function setEstadoItem(?bool $estadoItem): self
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

    public function setEstadoDebito(bool $estadoDebito): self
    {
        $this->estadoDebito = $estadoDebito;

        return $this;
    }


}
