<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SfGuardUserGroup
 *
 * @ORM\Table(name="sf_guard_user_group", indexes={@ORM\Index(name="sf_guard_user_group_FI_2", columns={"group_id"})})
 * @ORM\Entity
 */
class SfGuardUserGroup
{
    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="group_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $groupId;

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }


}
