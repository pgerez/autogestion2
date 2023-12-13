<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AreasAcceso
 *
 * @ORM\Table(name="areas_acceso")
 * @ORM\Entity
 */
class AreasAcceso
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_area_acceso", type="integer", nullable=false, options={"comment"="identificador de acceso a las areas"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAreaAcceso;

    /**
     * @var string
     *
     * @ORM\Column(name="id_acceso", type="string", length=10, nullable=false, options={"comment"="identificacion del area de acceso"})
     */
    private $idAcceso;

    /**
     * @var string
     *
     * @ORM\Column(name="area_acceso", type="string", length=50, nullable=false, options={"comment"="descripcion del area de acceso"})
     */
    private $areaAcceso;

    public function getIdAreaAcceso(): ?int
    {
        return $this->idAreaAcceso;
    }

    public function getIdAcceso(): ?string
    {
        return $this->idAcceso;
    }

    public function setIdAcceso(string $idAcceso): self
    {
        $this->idAcceso = $idAcceso;

        return $this;
    }

    public function getAreaAcceso(): ?string
    {
        return $this->areaAcceso;
    }

    public function setAreaAcceso(string $areaAcceso): self
    {
        $this->areaAcceso = $areaAcceso;

        return $this;
    }


}
