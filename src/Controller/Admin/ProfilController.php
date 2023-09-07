<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/admin/profil', name: 'app_admin_profil')]
    public function index(): Response
    {
        return $this->render('admin/profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }
}
