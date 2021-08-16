<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Tricks;
use App\Form\TrickType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $trick = new Tricks();
//        $image = new Images();
//
//        $image->setUrl('http://placehold.it/400X200')
//            ->setCaption('Titre 1');
//        $trick->addImage($image);
//        $image2 = new Images();
//
//        $image2->setUrl('http://placehold.it/400X200')
//            ->setCaption('Titre 2');
//        $trick->addImage($image2);

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);


        dump($trick);

        if ($form->isSubmitted() && $form->isValid()) {
//            $manager = $this->getDoctrine()->getManager();
            foreach($trick->getImages() as $image){
                $image->setTrick($trick);
                $manager->persist($image);
            }
            $manager->persist($trick);
            $manager->flush();
            $this->addFlash(
                'success',
                "La figure <strong>{$trick->getTitle()}</strong> a bien été enregistrée"
            );

            return $this->redirectToRoute('tricks_show', [
                'slug' => $trick->getSlug()
            ]);
        }
        return $this->render('tricks/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
