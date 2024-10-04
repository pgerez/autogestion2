<?php

namespace App\Entity;

use App\Repository\ProveedorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProveedorRepository::class)
 */
class Proveedor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cuit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $domicilio;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observacion;

    /**
     * @ORM\OneToMany(targetEntity=Afectacion::class, mappedBy="proveedor")
     */
    private $afectacions;

    public function __construct()
    {
        $this->afectacions = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nombre;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCuit(): ?string
    {
        return $this->cuit;
    }

    public function setCuit(?string $cuit): self
    {
        $this->cuit = $cuit;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDomicilio(): ?string
    {
        return $this->domicilio;
    }

    public function setDomicilio(?string $domicilio): self
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(?string $observacion): self
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * @return Collection<int, Afectacion>
     */
    public function getAfectacions(): Collection
    {
        return $this->afectacions;
    }

    public function addAfectacion(Afectacion $afectacion): self
    {
        if (!$this->afectacions->contains($afectacion)) {
            $this->afectacions[] = $afectacion;
            $afectacion->setProveedor($this);
        }

        return $this;
    }

    public function removeAfectacion(Afectacion $afectacion): self
    {
        if ($this->afectacions->removeElement($afectacion)) {
            // set the owning side to null (unless already changed)
            if ($afectacion->getProveedor() === $this) {
                $afectacion->setProveedor(null);
            }
        }

        return $this;
    }
    
}
