<?php

namespace App\Controller\Admin;

use App\Entity\User;

use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class inscriptionController extends AbstractController
{

        #[Route('/admin/inscription', name: 'app_admin_inscription')]
        public function ajouter(Request $request,entityManagerInterface $entityManager):Response{
        $user = new User();
        $formInscription = $this->createForm(inscriptionType::class,$user);
        $formInscription->handleRequest($request);
        if($formInscription->isSubmitted() && $formInscription->isValid()){
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Utilisateur a bien été inscrit'
            );
            return $this->redirectToRoute('app_main');
        }
        return $this->render('admin/inscription/inscription.html.twig',[
            'form'=>$formInscription
            ]

    );
        }
        #[Route('/admin/connexion','app_admin_connexion')]
        public function Connexion():Response{
            return $this->render('admin/Inscription/connexion.html.twig');
        }
}
