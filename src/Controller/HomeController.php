<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Repository\TricksRepository;
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
     * @param TricksRepository $repo
     * @return Response
     */
    public function show($slug, TricksRepository $repo){
        // Je récupère le trick qui correspond au slug
        $trick = $repo->findOneBySlug($slug);
        return $this->render('tricks/show.html.twig', [
            'trick' => $trick
        ]);
    }

}

