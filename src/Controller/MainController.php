<?php

namespace App\Controller;

use App\Entity\ArticlesFoot;
use App\Form\ArticleFootType;
use App\Repository\ArticlesFootRepository;
use App\Services\FileUploader;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use App\Form\MatchesStatusType;
use Goutte\Client;
class MainController extends AbstractController
{
  
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {   
       
       
        $client = new Client();
        //get details match in scrapping in footmercato
        $crawler = $client->request('GET', 'https://www.footmercato.net/live/');
       
       
    //retourner les logos des equipes
        $matches = $crawler->filter('.matchesGroup__list')->each(function ($node) {
            //si le mtach est en cours
         
          
               return [
                 
                   'matches' => $node->filter('.matchesGroup__match')->each(function ($node) {
                      
                    //dd score de chaque match
                   


                    

                       return [
                     
                           'link' => $node->filter('.matchFull__link')->attr('href'),
                           'teams'=> $node->filter('.matchFull__teams')->each(function ($node) {
                              
                               return [
                                   'team1' => $node->filter('.matchTeam__name')->text(),
                                   
                                
                                   //recuperer 2eme .matchTeam__name
                                   'team2' => $node->filter('.matchTeam__name')->eq(1)->text(),
 
                                  
                                
                                 
 
                               ];
                               
                              
                           }),
                           'logos'=> $node->filter('.matchFull__teams')->each(function ($node) {
                              
                               return [
                                   'logo1' => $node->filter('.matchTeam__logo')->filter('img')->first()->attr('src'),
                                   //'score' => $node->filter('.matchFull__score')->text(),
                                
                                   //recuperer 2eme .matchTeam__name
                                   'logo2' => $node->filter('.matchTeam__logo')->eq(1)->attr('src'),
 
                                   //'score1' => $node->filter('.matchFull__score')->eq(0)->text(),
                                
                                 
 
                               ];
                               
                            
                           }),
                            'score'=> $node->filter('.matchFull__score')->each(function ($node) {
                                    
                                 return [
                                      'score' => $node->filter('.matchFull__score')->filter('span')->first()->text(),
                                      //'score' => $node->filter('.matchFull__score')->text(),
                                  
                                   
     
                                      //'score1' => $node->filter('.matchFull__score')->eq(0)->text(),
                                  
                                    
     
                                 ];
                                 
     
                            }),
                          
                        
                       
                       
                       
                           
                            
                           
                     
                        
                          
                           
                       ];
                       
                  
                      
                   }),
 
                  
               ];
            
              
           });
       
 
       
       
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'matches' => $matches,
            
        ]);
       
      
    }
  
    public function getScore(){
        $client = new Client();
        //get details match in scrapping in footmercato
        $crawler = $client->request('GET', 'https://www.footmercato.net/live/');

        //si .FullScore__score existe
        $score = $crawler->filter('.matchFull__score')->each(function ($node) {
            return [
                'score' => $node->text() 
            ];
        });
        //associer le score a chaque match


    }

   
}

