<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Tricks;
use App\Form\CommentType;
use App\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {

    /**
     * @Route("/", name="homepage")
     * @param TricksRepository $repo
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function home(TricksRepository $repo, Request $request, PaginatorInterface $paginator)
    {
        $tricks = $repo->findAll();
//        $donnees = $repo->findBy(
//                array(),
//                array('createdAt' => 'ASC') // order criteria
//            );

//        $tricks = $paginator->paginate(
//            $donnees, // On passe les donnees
//            $request->query->getInt('page', 1), //Numero page en cours
//            6
//        );
        return $this->render(
            'home.html.twig',
            [
                'title' => "Le site communautaire SnowTricks",
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
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function show($slug, Tricks $trick, Request $request, EntityManagerInterface $manager, PaginatorInterface $paginator){
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
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository(Comment::class)->findByTrick(array('trick_id'=>$trick));

        $comments = $paginator->paginate(
            $query,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            10/*nbre d'éléments par page*/

        );
        return $this->render('tricks/show.html.twig', [
            'trick' => $trick,
            'comments' => $comments,
            'form' => $form->createView()
        ]);
    }

}

