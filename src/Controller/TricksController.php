<?php

namespace App\Controller;

use App\Entity\Tricks;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{
    /**
     * @Route("/tricks", name="tricks_index")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Tricks::class);
        $tricks = $repo->findAll();
        return $this->render('tricks/index.html.twig', [
            'tricks' => $tricks,
        ]);
    }

    /**
     * Permet de créer une annonce
     * @Route("/tricks/new", name="tricks_create")
     */
    public function create()
    {
        $trick = new Tricks();
        $form = $this->createFormBuilder($trick)
            ->add('title')
            ->add('description')
            ->add('coverImage')
            ->add('save', SubmitType::class, [
                'label' => 'Créer la nouvelle figure',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        return $this->render('tricks/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
