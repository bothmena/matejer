<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PhoneUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */

class PhoneShopRepository extends EntityRepository {
    
    public function getPhones($shop) {
        
        $qb = $this->createQueryBuilder('ps')
            ->addSelect('ps')
            ->where('ps.shop = :shop')
            ->setParameter('shop', $shop)
            ->setMaxResults(3);

        return $qb->getQuery()->getResult();
    }
}
