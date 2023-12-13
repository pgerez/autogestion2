<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nomencla2008
 *
 * @ORM\Table(name="nomencla2008")
 * @ORM\Entity
 */
class Nomencla2008
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
     * @ORM\Column(name="codigon", type="string", length=2, nullable=true, options={"fixed"=true})
     */
    private $codigon;

    /**
     * @var string|null
     *
     * @ORM\Column(name="subcodn", type="string", length=2, nullable=true, options={"fixed"=true})
     */
    private $subcodn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="letra", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $letra;

    /**
     * @var string|null
     *
     * @ORM\Column(name="item", type="string", length=3, nullable=true, options={"fixed"=true})
     */
    private $item;

    /**
     * @var float|null
     *
     * @ORM\Column(name="arancel", type="float", precision=10, scale=0, nullable=true)
     */
    private $arancel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tema", type="string", length=150, nullable=true, options={"fixed"=true})
     */
    private $tema;

    /**
     * @var string|null
     *
     * @ORM\Column(name="estado", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $estado;

    /**
     * @var int|null
     *
     * @ORM\Column(name="can_prac", type="integer", nullable=true)
     */
    private $canPrac;

    public function getRowId(): ?int
    {
        return $this->rowId;
    }

    public function getCodigon(): ?string
    {
        return $this->codigon;
    }

    public function setCodigon(?string $codigon): self
    {
        $this->codigon = $codigon;

        return $this;
    }

    public function getSubcodn(): ?string
    {
        return $this->subcodn;
    }

    public function setSubcodn(?string $subcodn): self
    {
        $this->subcodn = $subcodn;

        return $this;
    }

    public function getLetra(): ?string
    {
        return $this->letra;
    }

    public function setLetra(?string $letra): self
    {
        $this->letra = $letra;

        return $this;
    }

    public function getItem(): ?string
    {
        return $this->item;
    }

    public function setItem(?string $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getArancel(): ?float
    {
        return $this->arancel;
    }

    public function setArancel(?float $arancel): self
    {
        $this->arancel = $arancel;

        return $this;
    }

    public function getTema(): ?string
    {
        return $this->tema;
    }

    public function setTema(?string $tema): self
    {
        $this->tema = $tema;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(?string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getCanPrac(): ?int
    {
        return $this->canPrac;
    }

    public function setCanPrac(?int $canPrac): self
    {
        $this->canPrac = $canPrac;

        return $this;
    }


}
