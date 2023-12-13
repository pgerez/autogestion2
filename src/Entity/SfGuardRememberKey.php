<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SfGuardRememberKey
 *
 * @ORM\Table(name="sf_guard_remember_key")
 * @ORM\Entity
 */
class SfGuardRememberKey
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
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ipAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="remember_key", type="string", length=32, nullable=true)
     */
    private $rememberKey;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function getRememberKey(): ?string
    {
        return $this->rememberKey;
    }

    public function setRememberKey(?string $rememberKey): self
    {
        $this->rememberKey = $rememberKey;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


}
