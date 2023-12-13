<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Anexoii
 *
 * @ORM\Table(name="anexoii", indexes={@ORM\Index(name="Cod_H", columns={"Cod_H"}), @ORM\Index(name="Cod_OS", columns={"Cod_OS"}), @ORM\Index(name="id_entrada", columns={"id_entrada"})})
 * @ORM\Entity
 */
class Anexoii
{
    /**
     * @var int
     *
     * @ORM\Column(name="Num_Anexo", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numAnexo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_doc", type="string", length=5, nullable=false)
     */
    private $tipoDoc = '';

    /**
     * @var int
     *
     * @ORM\Column(name="documento", type="integer", nullable=false)
     */
    private $documento = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="apeynom", type="string", length=60, nullable=false)
     */
    private $apeynom = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nac", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $fechaNac = '0000-00-00';

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", length=1, nullable=false, options={"fixed"=true})
     */
    private $sexo = '';

    /**
     * @var string
     *
     * @ORM\Column(name="Cod_H", type="string", length=15, nullable=false)
     */
    private $codH = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="Cod_OS", type="integer", nullable=false)
     */
    private $codOs = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="Num_Afil", type="integer", nullable=false)
     */
    private $numAfil = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_benef", type="string", length=30, nullable=false)
     */
    private $tipoBenef = '';

    /**
     * @var string
     *
     * @ORM\Column(name="parentesco", type="string", length=30, nullable=false)
     */
    private $parentesco = '';

    /**
     * @var string
     *
     * @ORM\Column(name="medicos", type="string", length=30, nullable=false)
     */
    private $medicos = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Mes_Facturacion", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $mesFacturacion = '0000-00-00';

    /**
     * @var int
     *
     * @ORM\Column(name="cod_dev", type="integer", nullable=false)
     */
    private $codDev = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="Estado_Anexo", type="integer", nullable=false)
     */
    private $estadoAnexo = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_carga", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $fechaCarga = '0000-00-00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_carga", type="time", nullable=false, options={"default"="00:00:00"})
     */
    private $horaCarga = '00:00:00';

    /**
     * @var int
     *
     * @ORM\Column(name="mes", type="smallint", nullable=false)
     */
    private $mes = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="id_entrada", type="integer", nullable=false)
     */
    private $idEntrada = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="sf_guard_user_id", type="integer", nullable=true)
     */
    private $sfGuardUserId;

    /**
     * @ORM\OneToMany(targetEntity=ItemPrefacturacion::class, mappedBy="Num_Anexo",cascade={"persist"})
     */
    private $itemPrefacturacions;

    public function __toString()
    {
        return (string) $this->getNumAnexo();
    }

    public function __construct()
    {
        $this->itemPrefacturacions = new ArrayCollection();
    }

    public function getNumAnexo(): ?int
    {
        return $this->numAnexo;
    }

    public function getTipoDoc(): ?string
    {
        return $this->tipoDoc;
    }

    public function setTipoDoc(string $tipoDoc): self
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    public function getDocumento(): ?int
    {
        return $this->documento;
    }

    public function setDocumento(int $documento): self
    {
        $this->documento = $documento;

        return $this;
    }

    public function getApeynom(): ?string
    {
        return $this->apeynom;
    }

    public function setApeynom(string $apeynom): self
    {
        $this->apeynom = $apeynom;

        return $this;
    }

    public function getFechaNac(): ?\DateTimeInterface
    {
        return $this->fechaNac;
    }

    public function setFechaNac($fechaNac): self
    {
        $this->fechaNac = $fechaNac;

        return $this;
    }

    public function getSexo(): ?string
    {
        return $this->sexo;
    }

    public function setSexo(string $sexo): self
    {
        $this->sexo = $sexo;

        return $this;
    }

    public function getCodH(): ?string
    {
        return $this->codH;
    }

    public function setCodH(string $codH): self
    {
        $this->codH = $codH;

        return $this;
    }

    public function getCodOs(): ?int
    {
        return $this->codOs;
    }

    public function setCodOs($codOs): self
    {
        $this->codOs = $codOs;

        return $this;
    }

    public function getNumAfil(): ?int
    {
        return $this->numAfil;
    }

    public function setNumAfil($numAfil): self
    {
        $this->numAfil = $numAfil;

        return $this;
    }

    public function getTipoBenef(): ?string
    {
        return $this->tipoBenef;
    }

    public function setTipoBenef(string $tipoBenef): self
    {
        $this->tipoBenef = $tipoBenef;

        return $this;
    }

    public function getParentesco(): ?string
    {
        return $this->parentesco;
    }

    public function setParentesco(string $parentesco): self
    {
        $this->parentesco = $parentesco;

        return $this;
    }

    public function getMedicos(): ?string
    {
        return $this->medicos;
    }

    public function setMedicos(string $medicos): self
    {
        $this->medicos = $medicos;

        return $this;
    }

    public function getMesFacturacion(): ?\DateTimeInterface
    {
        return $this->mesFacturacion;
    }

    public function setMesFacturacion($mesFacturacion): self
    {
        $this->mesFacturacion = $mesFacturacion;

        return $this;
    }

    public function getCodDev(): ?int
    {
        return $this->codDev;
    }

    public function setCodDev($codDev): self
    {
        $this->codDev = $codDev;

        return $this;
    }

    public function getEstadoAnexo(): ?int
    {
        return $this->estadoAnexo;
    }

    public function setEstadoAnexo($estadoAnexo): self
    {
        $this->estadoAnexo = $estadoAnexo;

        return $this;
    }

    public function getFechaCarga(): ?\DateTimeInterface
    {
        return $this->fechaCarga;
    }

    public function setFechaCarga($fechaCarga): self
    {
        $this->fechaCarga = $fechaCarga;

        return $this;
    }

    public function getHoraCarga(): ?\DateTimeInterface
    {
        return $this->horaCarga;
    }

    public function setHoraCarga( $horaCarga): self
    {
        $this->horaCarga = $horaCarga;

        return $this;
    }

    public function getMes(): ?int
    {
        return $this->mes;
    }

    public function setMes($mes): self
    {
        $this->mes = $mes;

        return $this;
    }

    public function getIdEntrada(): ?int
    {
        return $this->idEntrada;
    }

    public function setIdEntrada($idEntrada): self
    {
        $this->idEntrada = $idEntrada;

        return $this;
    }

    public function getSfGuardUserId(): ?int
    {
        return $this->sfGuardUserId;
    }

    public function setSfGuardUserId($sfGuardUserId): self
    {
        $this->sfGuardUserId = $sfGuardUserId;

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
            $itemPrefacturacion->setNumAnexo($this);
        }

        return $this;
    }

    public function removeItemPrefacturacion(ItemPrefacturacion $itemPrefacturacion): self
    {
        if ($this->itemPrefacturacions->removeElement($itemPrefacturacion)) {
            // set the owning side to null (unless already changed)
            if ($itemPrefacturacion->getNumAnexo() === $this) {
                $itemPrefacturacion->setNumAnexo(null);
            }
        }

        return $this;
    }


}
