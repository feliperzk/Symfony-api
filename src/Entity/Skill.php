<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkillRepository")
 */
class Skill implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $skillDesc;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSkillDesc(): ?string
    {
        return $this->skillDesc;
    }

    public function setSkillDesc(string $skillDesc): self
    {
        $this->skillDesc = $skillDesc;

        return $this;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'skillDesc' => $this->getSkillDesc()
        ];
    }
}
