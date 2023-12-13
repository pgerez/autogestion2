<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sesiones
 *
 * @ORM\Table(name="sesiones")
 * @ORM\Entity
 */
class Sesiones
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
     * @var string
     *
     * @ORM\Column(name="_sessionid", type="string", length=50, nullable=false)
     */
    private $sessionid = '';

    /**
     * @var string
     *
     * @ORM\Column(name="Nombre_usuario", type="string", length=50, nullable=false)
     */
    private $nombreUsuario = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_entrada", type="time", nullable=false, options={"default"="00:00:00"})
     */
    private $horaEntrada = '00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_salida", type="time", nullable=false, options={"default"="00:00:00"})
     */
    private $horaSalida = '00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dia", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $dia = '0000-00-00';

    /**
     * @var string
     *
     * @ORM\Column(name="area", type="string", length=30, nullable=false)
     */
    private $area = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionid(): ?string
    {
        return $this->sessionid;
    }

    public function setSessionid(string $sessionid): self
    {
        $this->sessionid = $sessionid;

        return $this;
    }

    public function getNombreUsuario(): ?string
    {
        return $this->nombreUsuario;
    }

    public function setNombreUsuario(string $nombreUsuario): self
    {
        $this->nombreUsuario = $nombreUsuario;

        return $this;
    }

    public function getHoraEntrada(): ?\DateTimeInterface
    {
        return $this->horaEntrada;
    }

    public function setHoraEntrada(\DateTimeInterface $horaEntrada): self
    {
        $this->horaEntrada = $horaEntrada;

        return $this;
    }

    public function getHoraSalida(): ?\DateTimeInterface
    {
        return $this->horaSalida;
    }

    public function setHoraSalida(\DateTimeInterface $horaSalida): self
    {
        $this->horaSalida = $horaSalida;

        return $this;
    }

    public function getDia(): ?\DateTimeInterface
    {
        return $this->dia;
    }

    public function setDia(\DateTimeInterface $dia): self
    {
        $this->dia = $dia;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(string $area): self
    {
        $this->area = $area;

        return $this;
    }


}
