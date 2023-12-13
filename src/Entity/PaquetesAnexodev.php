<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaquetesAnexodev
 *
 * @ORM\Table(name="paquetes_anexodev")
 * @ORM\Entity
 */
class PaquetesAnexodev
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
     * @var int
     *
     * @ORM\Column(name="id_paq", type="integer", nullable=false)
     */
    private $idPaq;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_vencimiento", type="string", length=10, nullable=false)
     */
    private $estadoVencimiento;

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

    public function getIdPaq(): ?int
    {
        return $this->idPaq;
    }

    public function setIdPaq(int $idPaq): self
    {
        $this->idPaq = $idPaq;

        return $this;
    }

    public function getEstadoVencimiento(): ?string
    {
        return $this->estadoVencimiento;
    }

    public function setEstadoVencimiento(string $estadoVencimiento): self
    {
        $this->estadoVencimiento = $estadoVencimiento;

        return $this;
    }


}
