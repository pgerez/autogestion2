<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioArea
 *
 * @ORM\Table(name="usuario_area")
 * @ORM\Entity
 */
class UsuarioArea
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_usuario", type="integer", nullable=false, options={"comment"="Identificacion de Usuario"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="SYSusuario", type="string", length=50, nullable=false, options={"comment"="Identificador del usaurio en la BD sursde"})
     */
    private $sysusuario;

    /**
     * @var int
     *
     * @ORM\Column(name="id_acceso_FK", type="integer", nullable=false, options={"comment"="Identificador del accesoa a reas"})
     */
    private $idAccesoFk;

    public function getIdUsuario(): ?int
    {
        return $this->idUsuario;
    }

    public function getSysusuario(): ?string
    {
        return $this->sysusuario;
    }

    public function setSysusuario(string $sysusuario): self
    {
        $this->sysusuario = $sysusuario;

        return $this;
    }

    public function getIdAccesoFk(): ?int
    {
        return $this->idAccesoFk;
    }

    public function setIdAccesoFk(int $idAccesoFk): self
    {
        $this->idAccesoFk = $idAccesoFk;

        return $this;
    }


}
