<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaquetesDev
 *
 * @ORM\Table(name="paquetes_dev")
 * @ORM\Entity
 */
class PaquetesDev
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_paq", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPaq;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_os", type="string", length=12, nullable=false)
     */
    private $codOs;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_h", type="string", length=12, nullable=false)
     */
    private $codH;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad_anexos", type="integer", nullable=false)
     */
    private $cantidadAnexos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_retiro", type="date", nullable=false)
     */
    private $fechaRetiro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_venc_paq", type="date", nullable=false)
     */
    private $fechaVencPaq;

    /**
     * @var string
     *
     * @ORM\Column(name="apeynomresp", type="string", length=100, nullable=false)
     */
    private $apeynomresp;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=50, nullable=false)
     */
    private $usuario;

    /**
     * @var int
     *
     * @ORM\Column(name="estado_paq", type="integer", nullable=false, options={"comment"="1 esta bien 2 ha sido dado de baja por completo, 3 el paquete esta completo, 4 paquete mixto"})
     */
    private $estadoPaq;

    public function getIdPaq(): ?int
    {
        return $this->idPaq;
    }

    public function getCodOs(): ?string
    {
        return $this->codOs;
    }

    public function setCodOs(string $codOs): self
    {
        $this->codOs = $codOs;

        return $this;
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

    public function getCantidadAnexos(): ?int
    {
        return $this->cantidadAnexos;
    }

    public function setCantidadAnexos(int $cantidadAnexos): self
    {
        $this->cantidadAnexos = $cantidadAnexos;

        return $this;
    }

    public function getFechaRetiro(): ?\DateTimeInterface
    {
        return $this->fechaRetiro;
    }

    public function setFechaRetiro(\DateTimeInterface $fechaRetiro): self
    {
        $this->fechaRetiro = $fechaRetiro;

        return $this;
    }

    public function getFechaVencPaq(): ?\DateTimeInterface
    {
        return $this->fechaVencPaq;
    }

    public function setFechaVencPaq(\DateTimeInterface $fechaVencPaq): self
    {
        $this->fechaVencPaq = $fechaVencPaq;

        return $this;
    }

    public function getApeynomresp(): ?string
    {
        return $this->apeynomresp;
    }

    public function setApeynomresp(string $apeynomresp): self
    {
        $this->apeynomresp = $apeynomresp;

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

    public function getEstadoPaq(): ?int
    {
        return $this->estadoPaq;
    }

    public function setEstadoPaq(int $estadoPaq): self
    {
        $this->estadoPaq = $estadoPaq;

        return $this;
    }


}
