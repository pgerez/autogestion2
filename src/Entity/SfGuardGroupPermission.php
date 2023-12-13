<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SfGuardGroupPermission
 *
 * @ORM\Table(name="sf_guard_group_permission", indexes={@ORM\Index(name="sf_guard_group_permission_FI_2", columns={"permission_id"})})
 * @ORM\Entity
 */
class SfGuardGroupPermission
{
    /**
     * @var int
     *
     * @ORM\Column(name="group_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $groupId;

    /**
     * @var int
     *
     * @ORM\Column(name="permission_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $permissionId;

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function getPermissionId(): ?int
    {
        return $this->permissionId;
    }


}
