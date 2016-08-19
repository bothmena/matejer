<?php

namespace ABO\ShopBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ShopUserRepository extends EntityRepository{
    
    /*
     * User:Profile:show
     */
    public function getLastUserShops($user){
        $qb = $this->createQueryBuilder('su')
            ->addSelect('su')
             ->join('su.shop', 's')
            ->addSelect('s')
            ->where('su.user = :user')
            ->orderBy('su.date','DESC')
            ->setMaxResults(5)
            ->setParameter('user', $user);
        return $qb->getQuery()
            ->getResult();
    }
    
    /*
     * User:Profile:show
     */
    public function userShopsNb($user) {
        $qb = $this->createQueryBuilder('su')
            ->addSelect('su')
            ->select('COUNT(su)')
            ->where('su.user = :user')
            ->setParameter('user', $user);

        return $qb->getQuery()->getSingleScalarResult();
    }

    /*
     * Main:API:userData
     */
    public function getLightUserShops($user) {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('su')
            ->from('ABOShopBundle:ShopUser', 'su')
            ->join('su.shop', 's')
            ->addSelect('s')
            ->where('su.user = :user')
            ->setParameter('user', $user);

        return $qb->getQuery()->getResult();
    }
    
    /*
     * User:Shop:subscribed
     * User:Shop:shopByCategory
     * Main:Gallery:galleryShopUserData
     */
    public function getUserShops($user) {
        
        $qb = $this->_em->createQueryBuilder();
        $qb->select('su')
            ->from('ABOShopBundle:ShopUser', 'su')
            ->join('su.shop', 's')
            ->addSelect('s')
            ->join('s.image', 'i')
            ->addSelect('i')
            ->join('s.cover', 'c')
            ->addSelect('c')
            ->join('s.rateStat', 'r')
            ->addSelect('r')
            ->join('s.address', 'a')
            ->addSelect('a')
            ->where('su.user = :user')
            ->setParameter('user', $user);
        
        return $qb->getQuery();
    }
    
    /*
     * Shop:show:homeadmin, home
     */
    public function getLastFollowers($shop,$mr){
        
        $qb = $this->createQueryBuilder('su')
            ->addSelect('su')
            ->join('su.user', 'u')
            ->addSelect('u')
            ->where('su.shop = :shop')
            ->orderBy('su.date','DESC')
            ->setMaxResults($mr)
            ->setParameter('shop', $shop);
        
        return $qb->getQuery()
            ->getResult();
    }
    
    /*
     * Shop:show:followers
     */
    public function getUsers($shop){
        
        $qb = $this->createQueryBuilder('su')
            ->addSelect('su')
            ->join('su.user', 'u')
            ->addSelect('u')
            ->join('u.address', 'a')
            ->addSelect('a')
            ->where('su.shop = :shop')
            ->orderBy('su.date','DESC')
            ->setParameter('shop', $shop);
        
        return $qb->getQuery();
    }
}
