<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Form\DishType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dish", name="dish")
 */
class DishController extends AbstractController
{
    /**
     * @Route("/new", name="_new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dish = new Dish();
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dish);
            $entityManager->flush();
            $this->addFlash('success', 'Le plat à bien été crée');
            return $this->redirectToRoute('dish');
        }
        return $this->render('dish/new_dish.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
