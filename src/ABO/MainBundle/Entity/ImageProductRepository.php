<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImageProductRepository extends EntityRepository{
    
    /*
     * Main:Modal:product
     */
    public function findProductImages(array $catProds) {
        $qb = $this->createQueryBuilder('ip')
            ->addSelect('ip')
            ->join('ip.image', 'i')
            ->addSelect('i');
        $qb->add('where', $qb->expr()->in('ip.categoryProduct', ':catProd'))
            ->setParameter('catProd', $catProds);

        return $qb->getQuery()->getResult();
    }
}
