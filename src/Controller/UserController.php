<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{slug}", name="user_show")
     * @param Users $user
     * @return Response
     */
    public function index(Users $user)
    {
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
