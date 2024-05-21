<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ServiciosRepository;

/**
 * Servicios
 *
 * @ORM\Table(name="servicios")
 * @ORM\Entity(repositoryClass=ServiciosRepository::class)
 */
class Servicios
{
    /**
     * @var int
     *
     * @ORM\Column(name="codserv", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codserv;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion_servicio", type="string", length=50, nullable=true, options={"fixed"=true})
     */
    private $descripcionServicio;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_entero", type="string", length=50, nullable=false)
     */
    private $codEntero;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_rango", type="string", length=50, nullable=false)
     */
    private $codRango;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_fijo", type="string", length=50, nullable=false)
     */
    private $codFijo;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="estado", type="boolean", nullable=true)
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity=ItemPrefacturacion::class, mappedBy="codserv_FK")
     */
    private $itemPrefacturacions;

    public function __toString()
    {
        return $this->getCodserv();
    }

    public function __construct()
    {
        $this->itemPrefacturacions = new ArrayCollection();
    }

    public function getCodserv(): ?int
    {
        return $this->codserv;
    }

    public function getDescripcionServicio(): ?string
    {
        return utf8_encode($this->descripcionServicio);
    }

    public function setDescripcionServicio(?string $descripcionServicio): self
    {
        $this->descripcionServicio = $descripcionServicio;

        return $this;
    }

    public function getCodEntero(): ?string
    {
        return $this->codEntero;
    }

    public function setCodEntero(string $codEntero): self
    {
        $this->codEntero = $codEntero;

        return $this;
    }

    public function getCodRango(): ?string
    {
        return $this->codRango;
    }

    public function setCodRango(string $codRango): self
    {
        $this->codRango = $codRango;

        return $this;
    }

    public function getCodFijo(): ?string
    {
        return $this->codFijo;
    }

    public function setCodFijo(string $codFijo): self
    {
        $this->codFijo = $codFijo;

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
            $itemPrefacturacion->setCodservFK($this);
        }

        return $this;
    }

    public function removeItemPrefacturacion(ItemPrefacturacion $itemPrefacturacion): self
    {
        if ($this->itemPrefacturacions->removeElement($itemPrefacturacion)) {
            // set the owning side to null (unless already changed)
            if ($itemPrefacturacion->getCodservFK() === $this) {
                $itemPrefacturacion->setCodservFK(null);
            }
        }

        return $this;
    }

  


}
