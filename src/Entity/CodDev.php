<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CodDev
 *
 * @ORM\Table(name="cod_dev")
 * @ORM\Entity
 */
class CodDev
{
    /**
     * @var int
     *
     * @ORM\Column(name="cod_dev", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codDev = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=50, nullable=false)
     */
    private $descripcion = '';

    public function getCodDev(): ?int
    {
        return $this->codDev;
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


}
