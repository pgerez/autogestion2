<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstadoFactura
 *
 * @ORM\Table(name="estado_factura")
 * @ORM\Entity
 */
class EstadoFactura
{
    /**
     * @var bool
     *
     * @ORM\Column(name="cod_EstadoFactura", type="boolean", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codEstadofactura;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_EstadoFactura", type="string", length=50, nullable=false)
     */
    private $descripcionEstadofactura;

    public function getCodEstadofactura(): ?bool
    {
        return $this->codEstadofactura;
    }

    public function getDescripcionEstadofactura(): ?string
    {
        return $this->descripcionEstadofactura;
    }

    public function setDescripcionEstadofactura(string $descripcionEstadofactura): self
    {
        $this->descripcionEstadofactura = $descripcionEstadofactura;

        return $this;
    }


}
