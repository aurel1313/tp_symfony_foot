<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\InscriptionType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Security\EmailVerifier;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegisterUserController extends AbstractController
{

    #[Route('/admin/inscription', name: 'app_admin_inscription')]
    public function index(Request $request, entityManagerInterface $entityManager,UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form =$this->createForm(InscriptionType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
             $user->setPassword($userPasswordHasher->hashPassword(
                 $user,
                 $form->get('password')->getData()
             ));
            $userRepository= $entityManager->getRepository(User::class);
            $userOne = $userRepository->findAll();
            if(!$userOne){
                $user->setRoles(['ROLE_ADMIN']);
            }else{
                $user->setRoles(['ROLE_USER']);
            }
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('admin/inscription/inscription.html.twig', [
            'form'=>$form,
        ]);
    }


}
