<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Anexoii
 * @ORM\HasLifecycleCallbacks()
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
     * @var \Hospital
     *
     * @ORM\ManyToOne(targetEntity="Hospital")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Cod_H", referencedColumnName="id")
     * })
     */
    private $codH;

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
    private $mesFacturacion;

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
     * @Assert\Count(
     *        min = 1,
     *        minMessage = "Debe cargar al menos un Item de Prefacturacion",
     *      )
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity=ItemPrefacturacion::class, mappedBy="Num_Anexo", cascade={"persist"})
     */
    private $itemPrefacturacions;

    /**
     * @var bool
     *
     * @ORM\Column(name="cerrado", type="boolean", nullable=false)
     */
    private $cerrado = '0';

    /**
     * @Assert\Count(
     *       min = 1,
     *       minMessage = "Debe cargar al menos un Diagnostico Cie10",
     *     )
     * @ORM\OneToMany(targetEntity=AuditoriaAdministrativaCodCie10::class, mappedBy="auditoriaAdministrativaNumAnexo", cascade={"persist"})
     */
    private $cie10;

    /**
     * @ORM\Column(type="integer")
     */
    private $sistema = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="tipo_atencion", type="integer", nullable=true)
     */
    private $tipoAtencion = null;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $documentacion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_documentacion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_egreso;


    public function __toString()
    {
        return (string) $this->getNumAnexo();
    }

    public function __construct()
    {
        $this->itemPrefacturacions = new ArrayCollection();
        $this->setMesFacturacion(new \DateTime());
        $this->setHoraCarga(new \DateTime());
        $this->setFechaCarga(new \DateTime());
        $this->setFechaNac(new \DateTime());
        $this->setSexo(0);
        $this->setCerrado(0);
        $this->cie10 = new ArrayCollection();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setFechaValue(PreUpdateEventArgs $eventArgs)
    {
        if($eventArgs->hasChangedField('documentacion')):
            $this->fecha_documentacion = new \DateTimeImmutable();
        endif;
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
        return utf8_encode($this->apeynom);
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


    public function getCodH(): ?Hospital
    {
        return $this->codH;
    }

    public function setCodH(?Hospital $codH): self
    {
        $this->codH = $codH;

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

    public function getCerrado(): ?bool
    {
        return $this->cerrado;
    }

    public function setCerrado(bool $cerrado): self
    {
        $this->cerrado = $cerrado;

        return $this;
    }

    /**
     * @return Collection<int, AuditoriaAdministrativaCodCie10>
     */
    public function getCie10(): Collection
    {
        return $this->cie10;
    }

    public function addCie10(AuditoriaAdministrativaCodCie10 $cie10): self
    {
        if (!$this->cie10->contains($cie10)) {
            $this->cie10[] = $cie10;
            $cie10->setAuditoriaAdministrativaNumAnexo($this);
        }

        return $this;
    }

    public function removeCie10(AuditoriaAdministrativaCodCie10 $cie10): self
    {
        if ($this->cie10->removeElement($cie10)) {
            // set the owning side to null (unless already changed)
            if ($cie10->getAuditoriaAdministrativaNumAnexo() === $this) {
                $cie10->setAuditoriaAdministrativaNumAnexo(null);
            }
        }

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

    public function getTipoAtencion(): ?int
    {
        return $this->tipoAtencion;
    }

    public function setTipoAtencion(?int $tipoAtencion): self
    {
        $this->tipoAtencion = $tipoAtencion;

        return $this;
    }

    public function getDocumentacion(): ?bool
    {
        return $this->documentacion;
    }

    public function setDocumentacion(?bool $documentacion): self
    {
        $this->documentacion = $documentacion;

        return $this;
    }

    public function getFechaDocumentacion(): ?\DateTimeInterface
    {
        return $this->fecha_documentacion;
    }

    public function setFechaDocumentacion(?\DateTimeInterface $fecha_documentacion): self
    {
        $this->fecha_documentacion = $fecha_documentacion;

        return $this;
    }

    public function getFechaEgreso(): ?\DateTimeInterface
    {
        return $this->fecha_egreso;
    }

    public function setFechaEgreso(?\DateTimeInterface $fecha_egreso): self
    {
        $this->fecha_egreso = $fecha_egreso;

        return $this;
    }

    

}
