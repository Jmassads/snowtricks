<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories/new", name="categories_create")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $category = new Categories();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($category);
            $manager->flush();
            $this->addFlash(
                'success',
                "La catégorie a bien été enregistrée"
            );

            return $this->redirectToRoute('tricks_create', [

            ]);
        }
        return $this->render('categories/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
