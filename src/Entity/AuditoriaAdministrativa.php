<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuditoriaAdministrativa
 *
 * @ORM\Table(name="auditoria_administrativa")
 * @ORM\Entity
 */
class AuditoriaAdministrativa
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
     * @ORM\Column(name="Fecha_Carga", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $fechaCarga = '0000-00-00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_carga_final", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $fechaCargaFinal = '0000-00-00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_carga_final", type="time", nullable=false, options={"default"="00:00:00"})
     */
    private $horaCargaFinal = '00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_carga", type="time", nullable=false, options={"default"="00:00:00"})
     */
    private $horaCarga = '00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="cod_c10_1", type="string", length=20, nullable=false)
     */
    private $codC101 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="cod_c10_2", type="string", length=20, nullable=false)
     */
    private $codC102 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="cod_c10_3", type="string", length=20, nullable=false)
     */
    private $codC103 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="cod_c10_4", type="string", length=20, nullable=false)
     */
    private $codC104 = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fecha_Ingreso", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $fechaIngreso = '0000-00-00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fecha_Egreso", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $fechaEgreso = '0000-00-00';

    /**
     * @var int
     *
     * @ORM\Column(name="Total_Dias_Estadias", type="integer", nullable=false)
     */
    private $totalDiasEstadias = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Historia_Clinica", type="string", length=10, nullable=false)
     */
    private $historiaClinica = '';

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_aten", type="string", length=20, nullable=false)
     */
    private $tipoAten = '';

    /**
     * @var string
     *
     * @ORM\Column(name="codserv", type="string", length=100, nullable=false)
     */
    private $codserv;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_atencion", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $fechaAtencion = '0000-00-00';

    /**
     * @var string
     *
     * @ORM\Column(name="total_general_prefacturacion", type="string", length=20, nullable=false)
     */
    private $totalGeneralPrefacturacion = '';

    /**
     * @var string
     *
     * @ORM\Column(name="notas", type="string", length=150, nullable=false)
     */
    private $notas = '';

    /**
     * @var int|null
     *
     * @ORM\Column(name="sf_guard_user_id", type="integer", nullable=true)
     */
    private $sfGuardUserId;

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

    public function getFechaCargaFinal(): ?\DateTimeInterface
    {
        return $this->fechaCargaFinal;
    }

    public function setFechaCargaFinal(\DateTimeInterface $fechaCargaFinal): self
    {
        $this->fechaCargaFinal = $fechaCargaFinal;

        return $this;
    }

    public function getHoraCargaFinal(): ?\DateTimeInterface
    {
        return $this->horaCargaFinal;
    }

    public function setHoraCargaFinal(\DateTimeInterface $horaCargaFinal): self
    {
        $this->horaCargaFinal = $horaCargaFinal;

        return $this;
    }

    public function getHoraCarga(): ?\DateTimeInterface
    {
        return $this->horaCarga;
    }

    public function setHoraCarga(\DateTimeInterface $horaCarga): self
    {
        $this->horaCarga = $horaCarga;

        return $this;
    }

    public function getCodC101(): ?string
    {
        return $this->codC101;
    }

    public function setCodC101(string $codC101): self
    {
        $this->codC101 = $codC101;

        return $this;
    }

    public function getCodC102(): ?string
    {
        return $this->codC102;
    }

    public function setCodC102(string $codC102): self
    {
        $this->codC102 = $codC102;

        return $this;
    }

    public function getCodC103(): ?string
    {
        return $this->codC103;
    }

    public function setCodC103(string $codC103): self
    {
        $this->codC103 = $codC103;

        return $this;
    }

    public function getCodC104(): ?string
    {
        return $this->codC104;
    }

    public function setCodC104(string $codC104): self
    {
        $this->codC104 = $codC104;

        return $this;
    }

    public function getFechaIngreso(): ?\DateTimeInterface
    {
        return $this->fechaIngreso;
    }

    public function setFechaIngreso(\DateTimeInterface $fechaIngreso): self
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    public function getFechaEgreso(): ?\DateTimeInterface
    {
        return $this->fechaEgreso;
    }

    public function setFechaEgreso(\DateTimeInterface $fechaEgreso): self
    {
        $this->fechaEgreso = $fechaEgreso;

        return $this;
    }

    public function getTotalDiasEstadias(): ?int
    {
        return $this->totalDiasEstadias;
    }

    public function setTotalDiasEstadias(int $totalDiasEstadias): self
    {
        $this->totalDiasEstadias = $totalDiasEstadias;

        return $this;
    }

    public function getHistoriaClinica(): ?string
    {
        return $this->historiaClinica;
    }

    public function setHistoriaClinica(string $historiaClinica): self
    {
        $this->historiaClinica = $historiaClinica;

        return $this;
    }

    public function getTipoAten(): ?string
    {
        return $this->tipoAten;
    }

    public function setTipoAten(string $tipoAten): self
    {
        $this->tipoAten = $tipoAten;

        return $this;
    }

    public function getCodserv(): ?string
    {
        return $this->codserv;
    }

    public function setCodserv(string $codserv): self
    {
        $this->codserv = $codserv;

        return $this;
    }

    public function getFechaAtencion(): ?\DateTimeInterface
    {
        return $this->fechaAtencion;
    }

    public function setFechaAtencion(\DateTimeInterface $fechaAtencion): self
    {
        $this->fechaAtencion = $fechaAtencion;

        return $this;
    }

    public function getTotalGeneralPrefacturacion(): ?string
    {
        return $this->totalGeneralPrefacturacion;
    }

    public function setTotalGeneralPrefacturacion(string $totalGeneralPrefacturacion): self
    {
        $this->totalGeneralPrefacturacion = $totalGeneralPrefacturacion;

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
