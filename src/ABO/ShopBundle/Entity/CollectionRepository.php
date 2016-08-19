<?php

namespace ABO\ShopBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CollectionRepository extends EntityRepository{
    
    /*
     * shop:OfferType
     */
    public function getCollections(Shop $shop,$category){
        
        $parameters = array('shop' => $shop,'category' => $category);
        
        $qb = $this->_em->createQueryBuilder();
        $qb->select('c')
            ->from('ABOShopBundle:Collection', 'c')
            ->where('c.shop = :shop')
            ->andWhere($qb->expr()->orX(
                $qb->expr()->isNull('c.category'),
                $qb->expr()->eq('c.category', ':category')
            ))
            ->andWhere('c.anyParent = 0')
            ->setParameters($parameters);
        return $qb;
    }

    public function getNavCollection(Shop $shop){

        $qb = $this->_em->createQueryBuilder();
        $qb->select('c')
            ->from('ABOShopBundle:Collection', 'c')
            ->where('c.shop = :shop')
            ->setParameter('shop', $shop)
            ->orderBy('c.level', 'ASC');

        return $qb->getQuery()->getResult();
    }
}