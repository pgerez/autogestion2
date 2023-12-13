<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CapitaNroFactura
 *
 * @ORM\Table(name="capita_nro_factura")
 * @ORM\Entity
 */
class CapitaNroFactura
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
     * @ORM\Column(name="id_FK", type="integer", nullable=false, options={"comment"="este id proviene de la tabla hospital_has_departamentos"})
     */
    private $idFk;

    /**
     * @var string
     *
     * @ORM\Column(name="factura", type="string", length=20, nullable=false)
     */
    private $factura;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFk(): ?int
    {
        return $this->idFk;
    }

    public function setIdFk(int $idFk): self
    {
        $this->idFk = $idFk;

        return $this;
    }

    public function getFactura(): ?string
    {
        return $this->factura;
    }

    public function setFactura(string $factura): self
    {
        $this->factura = $factura;

        return $this;
    }


}
