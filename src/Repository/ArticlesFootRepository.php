<?php

namespace App\Repository;

use App\Entity\ArticlesFoot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArticlesFoot>
 *
 * @method ArticlesFoot|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticlesFoot|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticlesFoot[]    findAll()
 * @method ArticlesFoot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesFootRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticlesFoot::class);
    }
    //return all articles//
    public function findAllArticles(): array
    {
        //jointure entre la table articles et la table user//
        return $this->createQueryBuilder('af')->select('af','u')
            ->innerJoin('af.idUser', 'u')
            ->getQuery()
            ->getResult();
    

    
    }
    //delete by id//
    public function deleteArticle($id)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('DELETE FROM App\Entity\ArticlesFoot af WHERE af.id = :id');
        $query->setParameter('id', $id);
        dd($id);
    }
//    /**
//     * @return ArticlesFoot[] Returns an array of ArticlesFoot objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ArticlesFoot
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findArticleUser(): array
    {
        return $this->createQueryBuilder('af')
            ->join('user', 'u');
    }
}
