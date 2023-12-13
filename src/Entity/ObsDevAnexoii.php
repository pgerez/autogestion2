<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ObsDevAnexoii
 *
 * @ORM\Table(name="obs_dev_anexoii")
 * @ORM\Entity
 */
class ObsDevAnexoii
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
     * @ORM\Column(name="observaciones", type="string", length=100, nullable=false)
     */
    private $observaciones;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_dev", type="date", nullable=false)
     */
    private $fechaDev;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_dev", type="string", length=50, nullable=false)
     */
    private $usuarioDev;

    /**
     * @var int
     *
     * @ORM\Column(name="cod_dev", type="integer", nullable=false)
     */
    private $codDev;

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

    public function getFechaDev(): ?\DateTimeInterface
    {
        return $this->fechaDev;
    }

    public function setFechaDev(\DateTimeInterface $fechaDev): self
    {
        $this->fechaDev = $fechaDev;

        return $this;
    }

    public function getUsuarioDev(): ?string
    {
        return $this->usuarioDev;
    }

    public function setUsuarioDev(string $usuarioDev): self
    {
        $this->usuarioDev = $usuarioDev;

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
