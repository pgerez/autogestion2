<?php

namespace App\Entity;
use App\Repository\HospitalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hospital
 *
 * @ORM\Table(name="hospital")
 * @ORM\Entity(repositoryClass=HospitalRepository::class)
 */
class Hospital
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
     * @ORM\Column(name="codigoh", type="string", length=15, nullable=false)
     */
    private $codigoh = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="descriph", type="string", length=50, nullable=false)
     */
    private $descriph;

    /**
     * @var string
     *
     * @ORM\Column(name="pto_vta", type="string", length=20, nullable=false)
     */
    private $ptoVta = '';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="estado", type="boolean", nullable=true)
     */
    private $estado;

    /**
     * @var int
     *
     * @ORM\Column(name="imputacion", type="integer", nullable=false)
     */
    private $imputacion;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="hospital")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Liquidacion::class, mappedBy="hospital")
     */
    private $liquidacions;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hpgd;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cuit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Certificado::class, mappedBy="hospital")
     */
    private $certificados;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->liquidacions = new ArrayCollection();
        $this->certificados = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) utf8_decode($this->getDescriph());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigoh(): ?string
    {
        return $this->codigoh;
    }

    public function setCodigoh(string $codigoh): self
    {
        $this->codigoh = $codigoh;

        return $this;
    }

    public function getDescriph(): ?string
    {
        return utf8_decode($this->descriph);
    }

    public function setDescriph(string $descriph): self
    {
        $this->descriph = $descriph;

        return $this;
    }

    public function getPtoVta(): ?string
    {
        return $this->ptoVta;
    }

    public function setPtoVta(string $ptoVta): self
    {
        $this->ptoVta = $ptoVta;

        return $this;
    }

    public function getEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(?bool $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getImputacion(): ?int
    {
        return $this->imputacion;
    }

    public function setImputacion(int $imputacion): self
    {
        $this->imputacion = $imputacion;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setHospital($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getHospital() === $this) {
                $user->setHospital(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Liquidacion>
     */
    public function getLiquidacions(): Collection
    {
        return $this->liquidacions;
    }

    public function addLiquidacion(Liquidacion $liquidacion): self
    {
        if (!$this->liquidacions->contains($liquidacion)) {
            $this->liquidacions[] = $liquidacion;
            $liquidacion->setHospital($this);
        }

        return $this;
    }

    public function removeLiquidacion(Liquidacion $liquidacion): self
    {
        if ($this->liquidacions->removeElement($liquidacion)) {
            // set the owning side to null (unless already changed)
            if ($liquidacion->getHospital() === $this) {
                $liquidacion->setHospital(null);
            }
        }

        return $this;
    }

    public function getHpgd(): ?bool
    {
        return $this->hpgd;
    }

    public function setHpgd(?bool $hpgd): self
    {
        $this->hpgd = $hpgd;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Certificado>
     */
    public function getCertificados(): Collection
    {
        return $this->certificados;
    }

    public function addCertificado(Certificado $certificado): self
    {
        if (!$this->certificados->contains($certificado)) {
            $this->certificados[] = $certificado;
            $certificado->setHospital($this);
        }

        return $this;
    }

    public function removeCertificado(Certificado $certificado): self
    {
        if ($this->certificados->removeElement($certificado)) {
            // set the owning side to null (unless already changed)
            if ($certificado->getHospital() === $this) {
                $certificado->setHospital(null);
            }
        }

        return $this;
    }


}
