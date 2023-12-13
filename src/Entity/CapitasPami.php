<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CapitasPami
 *
 * @ORM\Table(name="capitas_pami")
 * @ORM\Entity
 */
class CapitasPami
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_capitas", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCapitas;

    /**
     * @var string
     *
     * @ORM\Column(name="id_hospital", type="string", length=10, nullable=false)
     */
    private $idHospital;

    /**
     * @var string
     *
     * @ORM\Column(name="id_departamento", type="string", length=10, nullable=false)
     */
    private $idDepartamento;

    /**
     * @var string
     *
     * @ORM\Column(name="nivel_1", type="string", length=10, nullable=false)
     */
    private $nivel1;

    public function getIdCapitas(): ?int
    {
        return $this->idCapitas;
    }

    public function getIdHospital(): ?string
    {
        return $this->idHospital;
    }

    public function setIdHospital(string $idHospital): self
    {
        $this->idHospital = $idHospital;

        return $this;
    }

    public function getIdDepartamento(): ?string
    {
        return $this->idDepartamento;
    }

    public function setIdDepartamento(string $idDepartamento): self
    {
        $this->idDepartamento = $idDepartamento;

        return $this;
    }

    public function getNivel1(): ?string
    {
        return $this->nivel1;
    }

    public function setNivel1(string $nivel1): self
    {
        $this->nivel1 = $nivel1;

        return $this;
    }


}
