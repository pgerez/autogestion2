<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DevolucionesDevAnexoii
 *
 * @ORM\Table(name="devoluciones_dev_anexoii")
 * @ORM\Entity
 */
class DevolucionesDevAnexoii
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
     * @ORM\Column(name="cod_motivo_FK", type="integer", nullable=false)
     */
    private $codMotivoFk = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="num_anexo", type="integer", nullable=false)
     */
    private $numAnexo = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="observacion_motivo", type="string", length=50, nullable=false, options={"comment"="se agrga la obs al motivo de devolucion"})
     */
    private $observacionMotivo;

    /**
     * @var int
     *
     * @ORM\Column(name="estado_anexo", type="integer", nullable=false)
     */
    private $estadoAnexo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodMotivoFk(): ?int
    {
        return $this->codMotivoFk;
    }

    public function setCodMotivoFk(int $codMotivoFk): self
    {
        $this->codMotivoFk = $codMotivoFk;

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

    public function getObservacionMotivo(): ?string
    {
        return $this->observacionMotivo;
    }

    public function setObservacionMotivo(string $observacionMotivo): self
    {
        $this->observacionMotivo = $observacionMotivo;

        return $this;
    }

    public function getEstadoAnexo(): ?int
    {
        return $this->estadoAnexo;
    }

    public function setEstadoAnexo(int $estadoAnexo): self
    {
        $this->estadoAnexo = $estadoAnexo;

        return $this;
    }


}
