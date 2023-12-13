<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstadoPaq
 *
 * @ORM\Table(name="estado_paq")
 * @ORM\Entity
 */
class EstadoPaq
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
     * @var int
     *
     * @ORM\Column(name="estado_paq", type="integer", nullable=false)
     */
    private $estadoPaq;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=30, nullable=false)
     */
    private $descripcion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstadoPaq(): ?int
    {
        return $this->estadoPaq;
    }

    public function setEstadoPaq(int $estadoPaq): self
    {
        $this->estadoPaq = $estadoPaq;

        return $this;
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
