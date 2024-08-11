<?php
    namespace App\Controller;
    use App\Entity\ArticlesFoot;
    use App\Repository\ArticlesFootRepository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;


use App\Form\ArticleFootType; // Add this line to import the missing class


    class ArticlesController extends AbstractController
    {
        #[Route('/articles', name: 'article_foot_list')]
        public function index(ArticlesFootRepository $articlesRepository): Response
        {
            $articles = $articlesRepository->findAllArticles();
           
           
            return $this->render('articles/index.html.twig', [
                'articles' => $articles,
            ]);
        }
        //add article//
        #[Route('/articles/new', name: 'article_new', methods: ['GET', 'POST'])]
        public function new(Request $request,EntityManagerInterface $entityManager, #[Autowire('%images_directory%')] string $photoDir): Response
        {
            $article = new ArticlesFoot();
            $form = $this->createForm(ArticleFootType::class, $article);
            $form->handleRequest($request);
            // definir l'idUser de l'article//
            $article->setIdUser($this->getUser());
            if ($form->isSubmitted() && $form->isValid()) {
                if($photo = $form->get('images')->getData()){
                  $photoName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME).'-'.uniqid().'.'.$photo->guessExtension();
                    $photo->move($photoDir,$photoName);
                    $article->setImages($photoName);
                }
            
                $entityManager->persist($article);
                $entityManager->flush();

                return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
            }

            return $this->render('articles/new.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        //edit article//
        #[Route('/articles/{id}', name: 'article_show', methods: ['GET'])]
        public function show(ArticlesFoot $article): Response
        {  
            return $this->render('articles/show.html.twig', [
                'article' => $article,
            ]);
        }
       
        //delete article//
        #[Route('/articles/{id}/delete', name: 'article_delete')]
        public function delete(Request $request, ArticlesFoot $article,EntityManagerInterface $entityManager): Response
        {   
           

            $entityManager->remove($article);
            $entityManager->flush();
            return $this->redirectToRoute('article_foot_list');
            
        }
      
      

        
        
        //modifier article//
        #[Route('/articles/{id}/edit', name: 'article_edit', methods: ['GET', 'POST'])]
        public function edit(Request $request, ArticlesFoot $article,EntityManagerInterface $entityManager,  #[Autowire('%images_directory%')] string $photoDir ): Response
        {
           

         // si tu a la permission d'editer//
           $form = $this->createForm(ArticleFootType::class, $article);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
              
                if($photo = $form->get('images')->getData()){
                    
                 
                  //remplacer l'ancienne image par la nouvelle//
                    if($article->getImages() && file_exists($photoDir.'/'.$article->getImages())){
                        unlink($photoDir.'/'.$article->getImages());
                    }
                        $nom = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME) ."." . $photo->guessExtension(); 
                        $photo->move($photoDir,$nom);
                        $article->setImages($nom);

                    
                  

                
                    
                    
                
                    

                }
              
                $entityManager->persist($article);
                $entityManager->flush();
                return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
            }

            return $this->render('articles/show.html.twig', [
                'article' => $article,
                'form' => $form ,
            ]);
        }
       
      

      
    }

?>