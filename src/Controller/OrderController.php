<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/order", name="order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/new", name="_new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($order);
            $entityManager->flush();
            $this->addFlash('success', 'La commande à bien été crée');
            return $this->redirectToRoute('order_new');
        }
        return $this->render('order/new_order.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/show", name="_show")
     */
    public function show(OrderRepository $orderRepository)
    {

        return $this->render('order/show_orders.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }
    /**
     * @Route("/delete/{id}", name="_delete", methods={"DELETE"})
     */
    public function delete(Order $order, Request $request): Response
    {
        $num = $order->getId();
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        $this->addFlash('success', 'La commande n° ' . $num .  ' est prête');

        return $this->redirectToRoute('order_show');
    }

    public function reload()
    {

    }
}
