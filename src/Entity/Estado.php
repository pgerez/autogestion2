<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estado
 *
 * @ORM\Table(name="estado")
 * @ORM\Entity
 */
class Estado
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
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=20, nullable=false)
     */
    private $estado = '';

    /**
     * @var string
     *
     * @ORM\Column(name="cod_estado", type="string", length=2, nullable=false, options={"fixed"=true})
     */
    private $codEstado = '';

    public function __toString()
    {
        return $this->getEstado();

    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getCodEstado(): ?string
    {
        return $this->codEstado;
    }

    public function setCodEstado(string $codEstado): self
    {
        $this->codEstado = $codEstado;

        return $this;
    }


}
