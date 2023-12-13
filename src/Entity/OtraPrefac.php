<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OtraPrefac
 *
 * @ORM\Table(name="otra_prefac", indexes={@ORM\Index(name="Cod_NHPGD", columns={"Cod_NHPGD"}), @ORM\Index(name="Num_Anexo", columns={"Num_Anexo"})})
 * @ORM\Entity
 */
class OtraPrefac
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
     * @var int
     *
     * @ORM\Column(name="Cod_NHPGD", type="integer", nullable=false)
     */
    private $codNhpgd = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="subcod", type="integer", nullable=false)
     */
    private $subcod = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="item", type="integer", nullable=false)
     */
    private $item = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Descripcion", type="string", length=50, nullable=false)
     */
    private $descripcion = '';

    /**
     * @var int
     *
     * @ORM\Column(name="Cantidad", type="integer", nullable=false)
     */
    private $cantidad = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="Precio_Unitario", type="integer", nullable=false)
     */
    private $precioUnitario = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="Total", type="integer", nullable=false)
     */
    private $total = '0';

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

    public function getCodNhpgd(): ?int
    {
        return $this->codNhpgd;
    }

    public function setCodNhpgd(int $codNhpgd): self
    {
        $this->codNhpgd = $codNhpgd;

        return $this;
    }

    public function getSubcod(): ?int
    {
        return $this->subcod;
    }

    public function setSubcod(int $subcod): self
    {
        $this->subcod = $subcod;

        return $this;
    }

    public function getItem(): ?int
    {
        return $this->item;
    }

    public function setItem(int $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

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

    public function getPrecioUnitario(): ?int
    {
        return $this->precioUnitario;
    }

    public function setPrecioUnitario(int $precioUnitario): self
    {
        $this->precioUnitario = $precioUnitario;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }


}
