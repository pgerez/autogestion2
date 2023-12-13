<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ControlUsuario
 *
 * @ORM\Table(name="control_usuario")
 * @ORM\Entity
 */
class ControlUsuario
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
     * @ORM\Column(name="Num_Anexo", type="integer", nullable=false)
     */
    private $numAnexo;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=35, nullable=false)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="Actividad", type="string", length=50, nullable=false)
     */
    private $actividad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Hora", type="time", nullable=false)
     */
    private $hora;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=100, nullable=false)
     */
    private $observacion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumAnexo(): ?int
    {
        return $this->numAnexo;
    }

    public function setNumAnexo(int $numAnexo): self
    {
        $this->numAnexo = $numAnexo;

        return $this;
    }

    public function getUsuario(): ?string
    {
        return $this->usuario;
    }

    public function setUsuario(string $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getActividad(): ?string
    {
        return $this->actividad;
    }

    public function setActividad(string $actividad): self
    {
        $this->actividad = $actividad;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(\DateTimeInterface $hora): self
    {
        $this->hora = $hora;

        return $this;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(string $observacion): self
    {
        $this->observacion = $observacion;

        return $this;
    }


}
