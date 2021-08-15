<?php

namespace App\Controller;

use App\Entity\Tricks;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
