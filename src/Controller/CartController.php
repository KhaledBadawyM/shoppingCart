<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Item;
use App\Entity\CartContainItems;
use App\Form\CartType;
use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="cart_index", methods={"GET"})
     */
    public function index(CartRepository $cartRepository): Response
    {
        return $this->render('cart/index.html.twig', [
            'carts' => $cartRepository->findAll(),
        ]);
    }



    /**
     * @Route("/new", name="cart_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cart = new Cart();
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cart);
            $entityManager->flush();

            return $this->redirectToRoute('cart_index');
        }

        return $this->render('cart/new.html.twig', [
            'cart' => $cart,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cart_show", methods={"GET"})
     */
    public function show(Cart $cart): Response
    {
        return $this->render('cart/show.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cart_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cart $cart): Response
    {
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cart_index');
        }

        return $this->render('cart/edit.html.twig', [
            'cart' => $cart,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cart_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cart $cart): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cart->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cart);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cart_index');
    }

    // /**
    // *@Router("/viewcart" , name="view_cart")
    // */
    // public function viewCart(){
    //   $mangager = $this->getDoctrine()->getManager();
    //   $user = $this->getUser();
    //   $user_cart = $this->getDoctrine()->getRepository(Cart::class)->findByUser($user);
    //   if($user_cart){
    //     $items = $this->getDoctrine()
    //             ->getRepository(CartContainItems::class)
    //             ->findBy(array('cart'=>$user_cart[0]->getId()));
    //     return $this->render('cart/show.html.twig',array(
    //       'items'=>$items,'cart'=>$user_cart[0],
    //     ));
    //   }
    // }

    /**
    *@Route("/addItem/{id}" , name = "add_item_cart")
    */
    public function addItemToCart($id){
      $auth = $this->isGranted('IS_AUTHENTICATED_FULLY');

      if($auth){ #if user logged in
        // echo "from add item method";
        // sleep(20);
        $manager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $item = $this->getDoctrine()
                      ->getRepository(Item::class)->find($id);
        $cart_exist = $this->getDoctrine()
                            ->getRepository(Cart::class)
                            ->findByUser($user);
        if(!$cart_exist){
          $cart =  new Cart();
          $cart->setUser($user);
          $manager->persist($cart);
          $manager->flush();

          $cart_items = new CartContainItems();
          $cart_items->setQuantity(1);
          $cart_items->setItem($item);
          $cart_items->setCart($cart);

          $manager->persist($cart_items);
          $manager->flush();

        }
        else{
          $cart = $cart_exist[0];
          $cart_items = new CartContainItems();
          $cart_items->setQuantity(1);
          $cart_items->setCart($cart);
          $cart_items->setItem($item);

          $manager->persist($cart_items);
          $manager->flush();
        }

        return $this->redirect($this->generateUrl('item_index'));
      }
      else
      {
        return $this->redirect($this->generateUrl('login'));
      }

    }

    /**
    * @Route("/remove/{$item}/{$cart}" , name ="remove_item")
    **/
    public function removeItem($item ,$cart){
      $manager = $this->getDoctrine()->getManager();
      $repo = $this->getDoctrine()->getRepository(CartContainItems::class);
      $cart_item = $repo->findOneBy(array('item'=>$item , 'cart'=>$cart));
      $manager->remove($cart_item);
      $manager->flush();
      // return $this->redirect($this->generateUrl('view_cart'));
    }

    /**
    * @Route("/clearcart/{$cart}" ,name ="clear_cart" )
    */
    public function clearCart($cart){
      $manager = $this->getDoctrine()->getManager();
      $repo = $this->getDoctrine()->getRepository(cartContainItems::class);
      $cart_item = $repo->findBy(array('cart'=>$cart));

      foreach($cart_item as $item){
        manager->remove($item);
        $manager->flush();
      }

      $cart_repo = $manager->getRepository(Cart::class)->findById($cart);
      $manager->remove($cart_repo);
      $manager->flush();
      return $this->redirect($this->generateUrl('view_cart'));
    }



}
