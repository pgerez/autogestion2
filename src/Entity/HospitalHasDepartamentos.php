<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HospitalHasDepartamentos
 *
 * @ORM\Table(name="hospital_has_departamentos")
 * @ORM\Entity
 */
class HospitalHasDepartamentos
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_NM", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idNm;

    /**
     * @var string
     *
     * @ORM\Column(name="id_capitas", type="string", length=10, nullable=false)
     */
    private $idCapitas;

    /**
     * @var int
     *
     * @ORM\Column(name="capita", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $capita;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $valor;

    /**
     * @var int
     *
     * @ORM\Column(name="estado", type="integer", nullable=false, options={"unsigned"=true,"comment"="0 inactivo-- 1 activo"})
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_Icapita", type="date", nullable=false)
     */
    private $fechaIcapita;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_Fcapita", type="date", nullable=false)
     */
    private $fechaFcapita;

    public function getIdNm(): ?int
    {
        return $this->idNm;
    }

    public function getIdCapitas(): ?string
    {
        return $this->idCapitas;
    }

    public function setIdCapitas(string $idCapitas): self
    {
        $this->idCapitas = $idCapitas;

        return $this;
    }

    public function getCapita(): ?int
    {
        return $this->capita;
    }

    public function setCapita(int $capita): self
    {
        $this->capita = $capita;

        return $this;
    }

    public function getValor(): ?string
    {
        return $this->valor;
    }

    public function setValor(string $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getEstado(): ?int
    {
        return $this->estado;
    }

    public function setEstado(int $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getFechaIcapita(): ?\DateTimeInterface
    {
        return $this->fechaIcapita;
    }

    public function setFechaIcapita(\DateTimeInterface $fechaIcapita): self
    {
        $this->fechaIcapita = $fechaIcapita;

        return $this;
    }

    public function getFechaFcapita(): ?\DateTimeInterface
    {
        return $this->fechaFcapita;
    }

    public function setFechaFcapita(\DateTimeInterface $fechaFcapita): self
    {
        $this->fechaFcapita = $fechaFcapita;

        return $this;
    }


}
