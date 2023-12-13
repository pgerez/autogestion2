<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HospitalSfGuardUser
 *
 * @ORM\Table(name="hospital_sf_guard_user", indexes={@ORM\Index(name="fk_hospital_sf_guard_user_hospital1", columns={"hospital_id"}), @ORM\Index(name="fk_hospital_sf_guard_user_sf_guard_user1", columns={"sf_guard_user_id"})})
 * @ORM\Entity
 */
class HospitalSfGuardUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="hospital_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $hospitalId;

    /**
     * @var int
     *
     * @ORM\Column(name="sf_guard_user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $sfGuardUserId;

    public function getHospitalId(): ?int
    {
        return $this->hospitalId;
    }

    public function getSfGuardUserId(): ?int
    {
        return $this->sfGuardUserId;
    }


}
