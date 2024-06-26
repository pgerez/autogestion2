<?php

// src/Entity/User.php
namespace App\Entity; 

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity=Hospital::class, inversedBy="users", cascade={"persist"})
     */
    private $hospital;

    /**
     * @var \ObrasSociales
     *
     * @ORM\ManyToOne(targetEntity="ObrasSociales")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="obrasocial_id", referencedColumnName="row_id")
     * })
     */
    private $obrasocial;
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function __construct()
    {
        parent::__construct();
    }

    public function getHospital(): ?Hospital
    {
        return $this->hospital;
    }

    public function setHospital(?Hospital $hospital): self
    {
        $this->hospital = $hospital;

        return $this;
    }

    public function getObrasocial(): ?ObrasSociales
    {
        return $this->obrasocial;
    }

    public function setObrasocial(?ObrasSociales $obrasocial): self
    {
        $this->obrasocial = $obrasocial;

        return $this;
    }
    
    
	
}