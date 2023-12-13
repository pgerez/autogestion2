<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departamentos
 *
 * @ORM\Table(name="departamentos")
 * @ORM\Entity
 */
class Departamentos
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_departamento", type="string", length=2, nullable=false, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDepartamento;

    /**
     * @var string
     *
     * @ORM\Column(name="departamento", type="string", length=10, nullable=false, options={"fixed"=true})
     */
    private $departamento = '';

    public function getIdDepartamento(): ?string
    {
        return $this->idDepartamento;
    }

    public function getDepartamento(): ?string
    {
        return $this->departamento;
    }

    public function setDepartamento(string $departamento): self
    {
        $this->departamento = $departamento;

        return $this;
    }


}
