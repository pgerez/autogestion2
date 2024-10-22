<?php

namespace App\Entity;

use App\Repository\MensajeRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass=MensajeRepository::class)
 */
class Mensaje
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $texto;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fos_user_user_id;

    /**
     * @var \Anexoii
     *
     * @ORM\ManyToOne(targetEntity="Anexoii")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="anexoii", referencedColumnName="Num_Anexo")
     * })
     */
    private $anexoii;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): self
    {
        $this->texto = $texto;

        return $this;
    }

    public function getFosUserUserId(): ?User
    {
        return $this->fos_user_user_id;
    }

    public function setFosUserUserId(?User $fos_user_user_id): self
    {
        $this->fos_user_user_id = $fos_user_user_id;

        return $this;
    }

    public function getAnexoii(): ?Anexoii
    {
        return $this->anexoii;
    }

    public function setAnexoii(?Anexoii $anexoii): self
    {
        $this->anexoii = $anexoii;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }
    
}
