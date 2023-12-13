<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ObrasSocialesRepository;

/**
 * ObrasSociales
 *
 * @ORM\Table(name="obras_sociales", indexes={@ORM\Index(name="codobra", columns={"codobra"}), @ORM\Index(name="codobra_2", columns={"codobra"})})
 * @ORM\Entity(repositoryClass=ObrasSocialesRepository::class)
 */
class ObrasSociales
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
     * @var int|null
     *
     * @ORM\Column(name="codobra", type="integer", nullable=true)
     */
    private $codobra;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sigla", type="string", length=25, nullable=true, options={"fixed"=true})
     */
    private $sigla;

    /**
     * @var string|null
     *
     * @ORM\Column(name="denomina", type="string", length=100, nullable=true, options={"fixed"=true})
     */
    private $denomina;

    /**
     * @var string|null
     *
     * @ORM\Column(name="domicilio", type="string", length=50, nullable=true, options={"fixed"=true})
     */
    private $domicilio;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cod_postal", type="string", length=100, nullable=true)
     */
    private $codPostal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="localidad", type="string", length=25, nullable=true, options={"fixed"=true})
     */
    private $localidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telefono", type="string", length=20, nullable=true, options={"fixed"=true})
     */
    private $telefono;

    /**
     * @var string|null
     *
     * @ORM\Column(name="codbco", type="string", length=2, nullable=true, options={"fixed"=true})
     */
    private $codbco;

    /**
     * @var string|null
     *
     * @ORM\Column(name="codsuc", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $codsuc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ctabanc", type="string", length=17, nullable=true, options={"fixed"=true})
     */
    private $ctabanc;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="estado", type="boolean", nullable=true)
     */
    private $estado;

    /**
     * @ORM\Column(type="integer")
     */
    private $cuit;

    public function __toString()
    {
        return (string) $this->getCodobra();
    }

    public function getRowId(): ?int
    {
        return $this->rowId;
    }

    public function getCodobra(): ?int
    {
        return $this->codobra;
    }

    public function setCodobra(?int $codobra): self
    {
        $this->codobra = $codobra;

        return $this;
    }

    public function getSigla(): ?string
    {
        return $this->sigla;
    }

    public function setSigla(?string $sigla): self
    {
        $this->sigla = $sigla;

        return $this;
    }

    public function getDenomina(): ?string
    {
        return $this->denomina;
    }

    public function setDenomina(?string $denomina): self
    {
        $this->denomina = $denomina;

        return $this;
    }

    public function getDomicilio(): ?string
    {
        return $this->domicilio;
    }

    public function setDomicilio(?string $domicilio): self
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    public function getCodPostal(): ?string
    {
        return $this->codPostal;
    }

    public function setCodPostal(?string $codPostal): self
    {
        $this->codPostal = $codPostal;

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(?string $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getCodbco(): ?string
    {
        return $this->codbco;
    }

    public function setCodbco(?string $codbco): self
    {
        $this->codbco = $codbco;

        return $this;
    }

    public function getCodsuc(): ?string
    {
        return $this->codsuc;
    }

    public function setCodsuc(?string $codsuc): self
    {
        $this->codsuc = $codsuc;

        return $this;
    }

    public function getCtabanc(): ?string
    {
        return $this->ctabanc;
    }

    public function setCtabanc(?string $ctabanc): self
    {
        $this->ctabanc = $ctabanc;

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

    public function getCuit(): ?int
    {
        return $this->cuit;
    }

    public function setCuit(int $cuit): self
    {
        $this->cuit = $cuit;

        return $this;
    }


}
