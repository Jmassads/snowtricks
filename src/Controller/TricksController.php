<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Images;
use App\Entity\Tricks;
use App\Form\CategoryType;
use App\Form\TrickType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TricksController extends AbstractController
{


    /**
     * Permet de créer une annonce
     * @Route("/tricks/new", name="tricks_create")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $trick = new Tricks();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($trick->getImages() as $image) {
                $image->setTrick($trick);
                $manager->persist($image);
            }

            foreach ($trick->getVideos() as $video) {
                $video->setTrick($trick);
                $manager->persist($video);
            }

            $trick->setAuthor($this->getUser());

            $trick->setCreatedAt(new \DateTimeImmutable());

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
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition
     * @Route("/trick/{slug}/edit", name="tricks_edit")
     * @Security("(is_granted('ROLE_USER') and user === trick.getAuthor()) or is_granted('ROLE_ADMIN')")
     * @param Tricks $trick
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Tricks $trick, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($trick->getImages() as $image) {
                $image->setTrick($trick);
                $manager->persist($image);
            }
            foreach ($trick->getVideos() as $video) {
                $video->setTrick($trick);
                $manager->persist($video);
            }
            $manager->persist($trick);
            $manager->flush();
            $this->addFlash(
                'success',
                "La figure <strong>{$trick->getTitle()}</strong> a bien été modifiée"
            );

            return $this->redirectToRoute('tricks_show', [
                'slug' => $trick->getSlug()
            ]);
        }
        return $this->render('tricks/edit.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick
        ]);
    }

    /**
     * Permet de supprimer une figure
     * @Route("/trick/{slug}/delete", name="tricks_delete")
     * @Security("(is_granted('ROLE_USER') and user === trick.getAuthor()) or is_granted('ROLE_ADMIN')")
     * @param Tricks $trick
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Tricks $trick, EntityManagerInterface $manager){
        $manager->remove($trick);
        $manager->flush();

        $this->addFlash(
            'success',
            "La figure <strong>{$trick->getTitle()}</strong> a bien été supprimée"
        );

        return $this->redirectToRoute("account_index");
    }
}

