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


		
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function __construct()
    {
        parent::__construct();
    }

    
    
	
}