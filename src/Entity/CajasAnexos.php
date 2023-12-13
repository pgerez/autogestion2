<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CajasAnexos
 *
 * @ORM\Table(name="cajas_anexos")
 * @ORM\Entity
 */
class CajasAnexos
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
     * @ORM\Column(name="numero_caja", type="integer", nullable=false)
     */
    private $numeroCaja;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=50, nullable=false)
     */
    private $usuario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_caja", type="datetime", nullable=false)
     */
    private $fechaCaja;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=100, nullable=false)
     */
    private $observacion;

    /**
     * @var string
     *
     * @ORM\Column(name="os_caja", type="string", length=20, nullable=false)
     */
    private $osCaja;

    /**
     * @var string
     *
     * @ORM\Column(name="hospital_id", type="string", length=30, nullable=false, options={"default"="115"})
     */
    private $hospitalId = '115';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCaja(): ?int
    {
        return $this->numeroCaja;
    }

    public function setNumeroCaja(int $numeroCaja): self
    {
        $this->numeroCaja = $numeroCaja;

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

    public function getFechaCaja(): ?\DateTimeInterface
    {
        return $this->fechaCaja;
    }

    public function setFechaCaja(\DateTimeInterface $fechaCaja): self
    {
        $this->fechaCaja = $fechaCaja;

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

    public function getOsCaja(): ?string
    {
        return $this->osCaja;
    }

    public function setOsCaja(string $osCaja): self
    {
        $this->osCaja = $osCaja;

        return $this;
    }

    public function getHospitalId(): ?string
    {
        return $this->hospitalId;
    }

    public function setHospitalId(string $hospitalId): self
    {
        $this->hospitalId = $hospitalId;

        return $this;
    }


}
