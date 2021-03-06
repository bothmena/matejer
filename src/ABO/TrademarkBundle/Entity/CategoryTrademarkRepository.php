<?php

namespace ABO\TrademarkBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryTrademarkRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryTrademarkRepository extends EntityRepository{
    
    /*
     * Trademark:Admin:navigation
     */
    public function getCategories($trademark) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ct')
            ->from('ABOTrademarkBundle:CategoryTrademark', 'ct')
            ->join('ct.category', 'c')
            ->addSelect('c')
            ->where('ct.trademark = :trademark')
            ->setParameter('trademark', $trademark);
        
        return $qb->getQuery()->getResult();
    }
    
    public function getCategoryTrademarks($category) {
        
        $qb = $this->_em->createQueryBuilder();
        $qb->select('ct')
            ->from('ABOTrademarkBundle:CategoryTrademark', 'ct')
            ->join('ct.trademark', 't')
            ->addSelect('t')
            ->where('ct.category = :category')
            ->setParameter('category', $category);
        
        return $qb->getQuery()->getResult();
    }
}
