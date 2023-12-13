<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Devoluciones
 *
 * @ORM\Table(name="devoluciones")
 * @ORM\Entity
 */
class Devoluciones
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_devolucion", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDevolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_devolucion", type="string", length=200, nullable=false)
     */
    private $descripcionDevolucion;

    public function getIdDevolucion(): ?int
    {
        return $this->idDevolucion;
    }

    public function getDescripcionDevolucion(): ?string
    {
        return $this->descripcionDevolucion;
    }

    public function setDescripcionDevolucion(string $descripcionDevolucion): self
    {
        $this->descripcionDevolucion = $descripcionDevolucion;

        return $this;
    }


}
