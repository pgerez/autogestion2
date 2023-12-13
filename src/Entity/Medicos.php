<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Medicos
 *
 * @ORM\Table(name="medicos")
 * @ORM\Entity
 */
class Medicos
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
     * @ORM\Column(name="matricula", type="string", length=10, nullable=true)
     */
    private $matricula;

    /**
     * @var string|null
     *
     * @ORM\Column(name="codcol", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $codcol;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomyape", type="string", length=30, nullable=true)
     */
    private $nomyape;

    public function getRowId(): ?int
    {
        return $this->rowId;
    }

    public function getMatricula(): ?string
    {
        return $this->matricula;
    }

    public function setMatricula(?string $matricula): self
    {
        $this->matricula = $matricula;

        return $this;
    }

    public function getCodcol(): ?string
    {
        return $this->codcol;
    }

    public function setCodcol(?string $codcol): self
    {
        $this->codcol = $codcol;

        return $this;
    }

    public function getNomyape(): ?string
    {
        return $this->nomyape;
    }

    public function setNomyape(?string $nomyape): self
    {
        $this->nomyape = $nomyape;

        return $this;
    }


}
