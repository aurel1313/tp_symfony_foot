<?php

namespace App\Controller;

use App\Entity\ArticlesFoot;
use App\Form\ArticleFootType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {   $footData = $this->MatchOfDay();
      $teams = $footData['matches'];


        return $this->render('main/index.html.twig', [
            'titre' => 'Accueil du foot',
            'matches'=>$footData['matches'],
            'teams'=>$teams
        ]);
    }
    public function MatchOfDay() : array
    {
        $token ='5a4e952b5ecf47b5a7e64915226910c8';
        $headers = [
            'X-Auth-Token' => $token,
        ];
        $client = HttpClient::create();


        // Get the date of the day


        $response =  $client->request('GET',"https://api.football-data.org/v4/competitions/2002/matches",[
            'headers' => $headers,
        ]);
        $data = json_decode($response->getContent(),true);



        return $data;
    }
    #[Route('/articles','article_foot')]
    public function CommunityList(entityManagerInterface $entityManager, Request $request,int $idArticle=null): Response{
        if($idArticle==null){
            $article = new ArticlesFoot();
        }
        $form =$this->createForm(ArticleFootType::class,$article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($article);
            $entityManager->flush();
            $this->redirectToRoute('article_foot');
        }
        return $this->render('main/articles/list_article.html.twig',[
            'form'=>$form
        ]);
    }
}
