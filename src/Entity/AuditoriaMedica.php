<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuditoriaMedica
 *
 * @ORM\Table(name="auditoria_medica")
 * @ORM\Entity
 */
class AuditoriaMedica
{
    /**
     * @var int
     *
     * @ORM\Column(name="Num_Anexo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numAnexo = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=15, nullable=false)
     */
    private $usuario = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_Carga", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $fechaCarga = '0000-00-00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time", nullable=false, options={"default"="00:00:00"})
     */
    private $hora = '00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="notas", type="string", length=100, nullable=false)
     */
    private $notas = '';

    public function getNumAnexo(): ?int
    {
        return $this->numAnexo;
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

    public function getFechaCarga(): ?\DateTimeInterface
    {
        return $this->fechaCarga;
    }

    public function setFechaCarga(\DateTimeInterface $fechaCarga): self
    {
        $this->fechaCarga = $fechaCarga;

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

    public function getNotas(): ?string
    {
        return $this->notas;
    }

    public function setNotas(string $notas): self
    {
        $this->notas = $notas;

        return $this;
    }


}
