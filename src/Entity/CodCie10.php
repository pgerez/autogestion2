<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CodCie10
 *
 * @ORM\Table(name="cod_cie10")
 * @ORM\Entity
 */
class CodCie10
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
     * @var string|null
     *
     * @ORM\Column(name="cod_3", type="string", length=6, nullable=true, options={"fixed"=true})
     */
    private $cod3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=49, nullable=true, options={"fixed"=true})
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity=AuditoriaAdministrativaCodCie10::class, mappedBy="codCie10Id", cascade={"persist"})
     */

    private $auditoria;

    public function __construct()
    {
        $this->auditoria = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) '('.$this->cod3.') '.$this->descripcion;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCod3(): ?string
    {
        return $this->cod3;
    }

    public function setCod3(?string $cod3): self
    {
        $this->cod3 = $cod3;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection<int, AuditoriaAdministrativaCodCie10>
     */
    public function getAuditoria(): Collection
    {
        return $this->auditoria;
    }

    public function addAuditorium(AuditoriaAdministrativaCodCie10 $auditorium): self
    {
        if (!$this->auditoria->contains($auditorium)) {
            $this->auditoria[] = $auditorium;
            $auditorium->setCodCie10Id($this);
        }

        return $this;
    }

    public function removeAuditorium(AuditoriaAdministrativaCodCie10 $auditorium): self
    {
        if ($this->auditoria->removeElement($auditorium)) {
            // set the owning side to null (unless already changed)
            if ($auditorium->getCodCie10Id() === $this) {
                $auditorium->setCodCie10Id(null);
            }
        }

        return $this;
    }


}
