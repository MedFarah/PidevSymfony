<?php

namespace GPBundle\Repository;
use GPBundle\Data\SearchData;

class ProduitRepository extends \Doctrine\ORM\EntityRepository
{
   public function findProductBynom($motcle){
    $query =$this->createQueryBuilder('p')
    ->where('p.nom like :nom')
    ->setParameter('nom', $motcle.'%')
    ->orderBy('p.nom' , 'ASC' )
    ->getQuery();
    return $query->getResult();

   }
   
    public function findSearch($search)
    {
      $query =$this->createQueryBuilder('p')
      ->where('p.prixr <= :prixr')
      ->setParameter('prixr', $search.'%')
      ->orderBy('p.prixr' , 'ASC' )
      ->getQuery();
      return $query->getResult();
     
      }

     
    
   }