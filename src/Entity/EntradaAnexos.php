<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntradaAnexos
 *
 * @ORM\Table(name="entrada_anexos")
 * @ORM\Entity
 */
class EntradaAnexos
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
     * @ORM\Column(name="cod_h", type="string", length=15, nullable=false)
     */
    private $codH = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="cod_os", type="integer", nullable=false)
     */
    private $codOs = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad_anexos", type="integer", nullable=false)
     */
    private $cantidadAnexos = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_llegada", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $fechaLlegada = '0000-00-00';

    /**
     * @var string
     *
     * @ORM\Column(name="mes_facturacion", type="string", length=30, nullable=false, options={"default"="0000-00-00"})
     */
    private $mesFacturacion = '0000-00-00';

    /**
     * @var int
     *
     * @ORM\Column(name="estado_paquete", type="integer", nullable=false)
     */
    private $estadoPaquete = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=30, nullable=false)
     */
    private $usuario = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_carga_paq", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $fechaCargaPaq = '0000-00-00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_carga_Iniciopaq", type="time", nullable=false, options={"default"="00:00:00"})
     */
    private $horaCargaIniciopaq = '00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_carga_finalpaq", type="time", nullable=false, options={"default"="00:00:00"})
     */
    private $horaCargaFinalpaq = '00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_final_cargapaq", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $fechaFinalCargapaq = '0000-00-00';

    /**
     * @var int
     *
     * @ORM\Column(name="id_caja", type="integer", nullable=false)
     */
    private $idCaja;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sf_guard_user_id", type="integer", nullable=true)
     */
    private $sfGuardUserId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodH(): ?string
    {
        return $this->codH;
    }

    public function setCodH(string $codH): self
    {
        $this->codH = $codH;

        return $this;
    }

    public function getCodOs(): ?int
    {
        return $this->codOs;
    }

    public function setCodOs(int $codOs): self
    {
        $this->codOs = $codOs;

        return $this;
    }

    public function getCantidadAnexos(): ?int
    {
        return $this->cantidadAnexos;
    }

    public function setCantidadAnexos(int $cantidadAnexos): self
    {
        $this->cantidadAnexos = $cantidadAnexos;

        return $this;
    }

    public function getFechaLlegada(): ?\DateTimeInterface
    {
        return $this->fechaLlegada;
    }

    public function setFechaLlegada(\DateTimeInterface $fechaLlegada): self
    {
        $this->fechaLlegada = $fechaLlegada;

        return $this;
    }

    public function getMesFacturacion(): ?string
    {
        return $this->mesFacturacion;
    }

    public function setMesFacturacion(string $mesFacturacion): self
    {
        $this->mesFacturacion = $mesFacturacion;

        return $this;
    }

    public function getEstadoPaquete(): ?int
    {
        return $this->estadoPaquete;
    }

    public function setEstadoPaquete(int $estadoPaquete): self
    {
        $this->estadoPaquete = $estadoPaquete;

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

    public function getFechaCargaPaq(): ?\DateTimeInterface
    {
        return $this->fechaCargaPaq;
    }

    public function setFechaCargaPaq(\DateTimeInterface $fechaCargaPaq): self
    {
        $this->fechaCargaPaq = $fechaCargaPaq;

        return $this;
    }

    public function getHoraCargaIniciopaq(): ?\DateTimeInterface
    {
        return $this->horaCargaIniciopaq;
    }

    public function setHoraCargaIniciopaq(\DateTimeInterface $horaCargaIniciopaq): self
    {
        $this->horaCargaIniciopaq = $horaCargaIniciopaq;

        return $this;
    }

    public function getHoraCargaFinalpaq(): ?\DateTimeInterface
    {
        return $this->horaCargaFinalpaq;
    }

    public function setHoraCargaFinalpaq(\DateTimeInterface $horaCargaFinalpaq): self
    {
        $this->horaCargaFinalpaq = $horaCargaFinalpaq;

        return $this;
    }

    public function getFechaFinalCargapaq(): ?\DateTimeInterface
    {
        return $this->fechaFinalCargapaq;
    }

    public function setFechaFinalCargapaq(\DateTimeInterface $fechaFinalCargapaq): self
    {
        $this->fechaFinalCargapaq = $fechaFinalCargapaq;

        return $this;
    }

    public function getIdCaja(): ?int
    {
        return $this->idCaja;
    }

    public function setIdCaja(int $idCaja): self
    {
        $this->idCaja = $idCaja;

        return $this;
    }

    public function getSfGuardUserId(): ?int
    {
        return $this->sfGuardUserId;
    }

    public function setSfGuardUserId(?int $sfGuardUserId): self
    {
        $this->sfGuardUserId = $sfGuardUserId;

        return $this;
    }


}
