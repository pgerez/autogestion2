<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reingresos
 *
 * @ORM\Table(name="reingresos")
 * @ORM\Entity
 */
class Reingresos
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reingreso", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReingreso;

    /**
     * @var int
     *
     * @ORM\Column(name="id_paq", type="integer", nullable=false)
     */
    private $idPaq;

    /**
     * @var int
     *
     * @ORM\Column(name="num_anexo", type="integer", nullable=false)
     */
    private $numAnexo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_recepcion", type="date", nullable=false)
     */
    private $fechaRecepcion;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_reingreso", type="string", length=50, nullable=false)
     */
    private $usuarioReingreso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_carga_reingreso", type="date", nullable=false)
     */
    private $fechaCargaReingreso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_carga_reingreso", type="time", nullable=false)
     */
    private $horaCargaReingreso;

    public function getIdReingreso(): ?int
    {
        return $this->idReingreso;
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

    public function getNumAnexo(): ?int
    {
        return $this->numAnexo;
    }

    public function setNumAnexo(int $numAnexo): self
    {
        $this->numAnexo = $numAnexo;

        return $this;
    }

    public function getFechaRecepcion(): ?\DateTimeInterface
    {
        return $this->fechaRecepcion;
    }

    public function setFechaRecepcion(\DateTimeInterface $fechaRecepcion): self
    {
        $this->fechaRecepcion = $fechaRecepcion;

        return $this;
    }

    public function getUsuarioReingreso(): ?string
    {
        return $this->usuarioReingreso;
    }

    public function setUsuarioReingreso(string $usuarioReingreso): self
    {
        $this->usuarioReingreso = $usuarioReingreso;

        return $this;
    }

    public function getFechaCargaReingreso(): ?\DateTimeInterface
    {
        return $this->fechaCargaReingreso;
    }

    public function setFechaCargaReingreso(\DateTimeInterface $fechaCargaReingreso): self
    {
        $this->fechaCargaReingreso = $fechaCargaReingreso;

        return $this;
    }

    public function getHoraCargaReingreso(): ?\DateTimeInterface
    {
        return $this->horaCargaReingreso;
    }

    public function setHoraCargaReingreso(\DateTimeInterface $horaCargaReingreso): self
    {
        $this->horaCargaReingreso = $horaCargaReingreso;

        return $this;
    }


}
