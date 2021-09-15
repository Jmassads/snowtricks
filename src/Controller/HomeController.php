<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Tricks;
use App\Form\CommentType;
use App\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {

    /**
     * @Route("/", name="homepage")
     * @param TricksRepository $repo
     * @return Response
     */
    public function home(TricksRepository $repo)
    {
        $tricks = $repo->findAll();
        $tricks = $repo->findBy(
                array(),
                array('createdAt' => 'ASC') // order criteria
            );
        return $this->render(
            'home.html.twig',
            [
                'title' => "Snowtricks",
                'tricks' => $tricks,
            ]
        );
    }

    /**
     * Permet d'afficher un seule figure
     * @Route("/trick/{slug}", name="tricks_show")
     * @param $slug
     * @param Tricks $trick
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function show($slug, Tricks $trick, Request $request, EntityManagerInterface $manager ){
        // Je récupère le trick qui correspond au slug
//        $trick = $repo->findOneBySlug($slug);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setTrick($trick)
                    ->setAuthor($this->getUser());
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre commentaire a bien été pris en compte'
            );
        }
        return $this->render('tricks/show.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

}

