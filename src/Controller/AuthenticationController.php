<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{
    #[Route('/', name: 'app_authentication')]
    public function index(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $email = $user->getEmail();
            $pwd = $user->getPassword();
            return $this->render('authentication/index.html.twig',
                [

                    'email'=>$email,
                    'pwd'=>$pwd
                ]);
        }
        else{
            return $this->render('authentication/index.html.twig', ['form'=>$form->createView()]);
        }
    }

    #[Route('/authenticate', name: 'app_authenticate')]
    public function authentication(Request $request){

    }
}
