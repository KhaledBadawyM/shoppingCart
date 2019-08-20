<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */


 /**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"cart" = "Cart", "ordercart" = "OrderCart", "wishlistcart"="WishListCart"})
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="cart", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CartContainItems", mappedBy="cart")
     */
    private $cartContainItems;


    public function __construct()
    {
        // $this->cartHasItems = new ArrayCollection();
        $this->cartContainItems = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="integer")
     */
    // private $User;
    //
    // /**
    //  * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="cart", cascade={"persist", "remove"})
    //  * @ORM\JoinColumn(nullable=false)
    //  */
    // private $user;
    //
    // // /**
    // //  * @ORM\Column(type="integer")
    // //  */
    // // private $item;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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
            $cartContainItem->setCart($this);
        }

        return $this;
    }

    public function removeCartContainItem(CartContainItems $cartContainItem): self
    {
        if ($this->cartContainItems->contains($cartContainItem)) {
            $this->cartContainItems->removeElement($cartContainItem);
            // set the owning side to null (unless already changed)
            if ($cartContainItem->getCart() === $this) {
                $cartContainItem->setCart(null);
            }
        }

        return $this;
    }




    // public function getItem(): ?int
    // {
    //     return $this->item;
    // }
    //
    // public function setItem(int $item): self
    // {
    //     $this->item = $item;
    //
    //     return $this;
    // }
}

/**
 * @ORM\Entity
 */
class OrderCart extends Cart
{
    // ...
}

/**
 * @ORM\Entity
 */
class WishListCart extends Cart
{
    // ...
}
