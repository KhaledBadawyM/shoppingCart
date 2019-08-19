<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */

 /**
 * @Entity
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"item" = "Item", "saleitem" = "SaleItem", "normalitem"="NormalItem"})
 */

class Item
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
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CartContainItems", mappedBy="item")
     */
    private $cartContainItems;


    public function __construct()
    {
        // $this->cartHasItems = new ArrayCollection();
        $this->cartContainItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|CartContainItems[]
     */
    public function getCartContainItems(): Collection
    {
        return $this->cartContainItems;
    }

    public function addCartContainItem(CartContainItems $cartContainItem): self
    {
        if (!$this->cartContainItems->contains($cartContainItem)) {
            $this->cartContainItems[] = $cartContainItem;
            $cartContainItem->setItem($this);
        }

        return $this;
    }

    public function removeCartContainItem(CartContainItems $cartContainItem): self
    {
        if ($this->cartContainItems->contains($cartContainItem)) {
            $this->cartContainItems->removeElement($cartContainItem);
            // set the owning side to null (unless already changed)
            if ($cartContainItem->getItem() === $this) {
                $cartContainItem->setItem(null);
            }
        }

        return $this;
    }
}

/**
 * @Entity
 */
class SaleItem extends Item
{
    // ...
}


/**
 * @Entity
 */
class NormalItem extends Item
{
    // ...
}
