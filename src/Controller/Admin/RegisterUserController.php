<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\InscriptionType;
use Cassandra\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterUserController extends AbstractController
{
    #[Route('/admin/inscription', name: 'app_admin_inscription')]
    public function index(Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form =$this->createForm(InscriptionType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
             $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            //return $this->redirectToRoute('app_main');
        }
        return $this->render('admin/inscription/inscription.html.twig', [
            'form'=>$form
        ]);
    }
}
