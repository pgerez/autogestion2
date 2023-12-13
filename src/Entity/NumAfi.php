<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NumAfi
 *
 * @ORM\Table(name="num_afi")
 * @ORM\Entity
 */
class NumAfi
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
     * @var string
     *
     * @ORM\Column(name="numAfi", type="string", length=10, nullable=false)
     */
    private $numafi;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumafi(): ?string
    {
        return $this->numafi;
    }

    public function setNumafi(string $numafi): self
    {
        $this->numafi = $numafi;

        return $this;
    }


}
