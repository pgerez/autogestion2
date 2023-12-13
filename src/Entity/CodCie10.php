<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CodCie10
 *
 * @ORM\Table(name="cod_cie10")
 * @ORM\Entity
 */
class CodCie10
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cod_3", type="string", length=6, nullable=true, options={"fixed"=true})
     */
    private $cod3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=49, nullable=true, options={"fixed"=true})
     */
    private $descripcion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCod3(): ?string
    {
        return $this->cod3;
    }

    public function setCod3(?string $cod3): self
    {
        $this->cod3 = $cod3;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }


}
