<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestRepository")
 */
class Test
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
    private $method1;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMethod1(): ?string
    {
        return $this->method1;
    }

    public function setMethod1(string $method1): self
    {
        $this->method1 = $method1;

        return $this;
    }
}
