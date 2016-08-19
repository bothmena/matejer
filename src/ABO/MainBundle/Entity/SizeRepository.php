<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

class SizeRepository extends EntityRepository {
    
    /*
     * Main:ProductSubscriber
     */
    public function getSelectedSizes($sizesIds) {
        
        $qb = $this->createQueryBuilder('s');
        $qb->add('where', $qb->expr()->in('s.id', ':sizes_ids'))
        ->setParameter('sizes_ids', $sizesIds);
        return $qb->getQuery()->getResult();
    }
}
