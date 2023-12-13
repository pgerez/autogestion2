<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DevAnexoii
 *
 * @ORM\Table(name="dev_anexoii", indexes={@ORM\Index(name="id", columns={"id"}), @ORM\Index(name="Num_Anexo", columns={"Num_Anexo"})})
 * @ORM\Entity
 */
class DevAnexoii
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
     * @ORM\Column(name="Num_Anexo", type="integer", nullable=false)
     */
    private $numAnexo = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=100, nullable=false)
     */
    private $observaciones = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fecha_Carga", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $fechaCarga = '0000-00-00';

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=50, nullable=false)
     */
    private $usuario = '';

    /**
     * @var int
     *
     * @ORM\Column(name="cod_dev", type="integer", nullable=false)
     */
    private $codDev = '0';

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

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getFechaCarga(): ?\DateTimeInterface
    {
        return $this->fechaCarga;
    }

    public function setFechaCarga(\DateTimeInterface $fechaCarga): self
    {
        $this->fechaCarga = $fechaCarga;

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

    public function getCodDev(): ?int
    {
        return $this->codDev;
    }

    public function setCodDev(int $codDev): self
    {
        $this->codDev = $codDev;

        return $this;
    }


}
