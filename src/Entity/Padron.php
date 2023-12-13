<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Padron
 *
 * @ORM\Table(name="padron", indexes={@ORM\Index(name="row_id", columns={"row_id"})})
 * @ORM\Entity
 */
class Padron
{
    /**
     * @var int
     *
     * @ORM\Column(name="row_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $rowId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tipo_doc", type="string", length=2, nullable=true, options={"fixed"=true})
     */
    private $tipoDoc;

    /**
     * @var int|null
     *
     * @ORM\Column(name="documento", type="integer", nullable=true)
     */
    private $documento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apenom", type="string", length=45, nullable=true, options={"fixed"=true})
     */
    private $apenom;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_nac", type="date", nullable=true)
     */
    private $fechaNac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sexo", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $sexo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="codigo_afi", type="integer", nullable=true)
     */
    private $codigoAfi;

    /**
     * @var int|null
     *
     * @ORM\Column(name="codigo_os", type="integer", nullable=true)
     */
    private $codigoOs;

    public function getRowId(): ?int
    {
        return $this->rowId;
    }

    public function getTipoDoc(): ?string
    {
        return $this->tipoDoc;
    }

    public function setTipoDoc(?string $tipoDoc): self
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    public function getDocumento(): ?int
    {
        return $this->documento;
    }

    public function setDocumento(?int $documento): self
    {
        $this->documento = $documento;

        return $this;
    }

    public function getApenom(): ?string
    {
        return $this->apenom;
    }

    public function setApenom(?string $apenom): self
    {
        $this->apenom = $apenom;

        return $this;
    }

    public function getFechaNac(): ?\DateTimeInterface
    {
        return $this->fechaNac;
    }

    public function setFechaNac(?\DateTimeInterface $fechaNac): self
    {
        $this->fechaNac = $fechaNac;

        return $this;
    }

    public function getSexo(): ?string
    {
        return $this->sexo;
    }

    public function setSexo(?string $sexo): self
    {
        $this->sexo = $sexo;

        return $this;
    }

    public function getCodigoAfi(): ?int
    {
        return $this->codigoAfi;
    }

    public function setCodigoAfi(?int $codigoAfi): self
    {
        $this->codigoAfi = $codigoAfi;

        return $this;
    }

    public function getCodigoOs(): ?int
    {
        return $this->codigoOs;
    }

    public function setCodigoOs(?int $codigoOs): self
    {
        $this->codigoOs = $codigoOs;

        return $this;
    }


}
