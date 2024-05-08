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
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=CodCie10::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cod_cie10_id", referencedColumnName="id")
     * })
     */
    private $codCie10Id;

    /**
     * @ORM\ManyToOne(targetEntity=Anexoii::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="auditoria_administrativa_Num_Anexo", referencedColumnName="Num_Anexo")
     * })
     */
    private $auditoriaAdministrativaNumAnexo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodCie10Id(): ?CodCie10
    {
        return $this->codCie10Id;
    }

    public function setCodCie10Id(?CodCie10 $codCie10Id): self
    {
        $this->codCie10Id = $codCie10Id;

        return $this;
    }

    public function getAuditoriaAdministrativaNumAnexo(): ?Anexoii
    {
        return $this->auditoriaAdministrativaNumAnexo;
    }

    public function setAuditoriaAdministrativaNumAnexo(?Anexoii $auditoriaAdministrativaNumAnexo): self
    {
        $this->auditoriaAdministrativaNumAnexo = $auditoriaAdministrativaNumAnexo;

        return $this;
    }

    
    


}
