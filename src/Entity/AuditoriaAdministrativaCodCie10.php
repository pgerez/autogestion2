<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuditoriaAdministrativaCodCie10
 *
 * @ORM\Table(name="auditoria_administrativa_cod_cie10", indexes={@ORM\Index(name="fk_auditoria_administrativa_cod_cie10_auditoria_administrativa1", columns={"auditoria_administrativa_Num_Anexo"}), @ORM\Index(name="fk_auditoria_administrativa_cod_cie10_cod_cie101", columns={"cod_cie10_id"})})
 * @ORM\Entity
 */
class AuditoriaAdministrativaCodCie10
{
    /**
     * @var int
     *
     * @ORM\Column(name="cod_cie10_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $codCie10Id;

    /**
     * @var int
     *
     * @ORM\Column(name="auditoria_administrativa_Num_Anexo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $auditoriaAdministrativaNumAnexo;

    public function getCodCie10Id(): ?int
    {
        return $this->codCie10Id;
    }

    public function getAuditoriaAdministrativaNumAnexo(): ?int
    {
        return $this->auditoriaAdministrativaNumAnexo;
    }


}
