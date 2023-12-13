<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstadoAnexos
 *
 * @ORM\Table(name="estado_anexos")
 * @ORM\Entity
 */
class EstadoAnexos
{
    /**
     * @var int
     *
     * @ORM\Column(name="Estado_Anexo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $estadoAnexo = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Descripcion_E", type="string", length=50, nullable=false)
     */
    private $descripcionE = '';

    public function getEstadoAnexo(): ?int
    {
        return $this->estadoAnexo;
    }

    public function getDescripcionE(): ?string
    {
        return $this->descripcionE;
    }

    public function setDescripcionE(string $descripcionE): self
    {
        $this->descripcionE = $descripcionE;

        return $this;
    }


}
