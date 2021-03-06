<?php

namespace ABO\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own rpstom
 * repository methods below.
 */
class RatingProductRepository extends EntityRepository{
    
    /*
     * User:Profile:show
     */
    public function userProdsRtNb($user) {
        $qb = $this->createQueryBuilder('rp')
            ->addSelect('rp')
            ->select('COUNT(rp)')
            ->where('rp.user = :user')
            ->setParameter('user', $user);

        return $qb->getQuery()->getSingleScalarResult();
    }

    /*
     * Shop:Product:reviews
     */
    public function getProductReviewsUser($catProd, $user){

        $parameters = array('catProd'=>$catProd, 'user'=>$user);

        $qb = $this->_em->createQueryBuilder();
        $qb->select('rp')
            ->from('ABOMainBundle:RatingProduct', 'rp')
            ->join('rp.rate', 'r')
            ->addSelect('r')
            ->join('rp.user', 'u')
            ->addSelect('u')
            ->andWhere('rp.categoryProduct = :catProd')
            ->andWhere('rp.user != :user')
            ->orderBy('rp.date')
            ->setParameters($parameters);

        return $qb->getQuery();
    }

    /*
     * User:Product:reviews
     */
    public function userReviews($user) {
        $qb = $this->createQueryBuilder('rp')
            ->addSelect('rp')
            ->join('rp.rate', 'r')
            ->addSelect('r')
            ->join('rp.categoryProduct', 'cp')
            ->addSelect('cp')
            ->join('cp.category', 'c')
            ->addSelect('c')
            ->join('cp.product', 'p')
            ->addSelect('p')
            ->where('rp.user = :user')
            ->setParameter('user', $user);

        return $qb->getQuery();
    }

    /*
     * User:Product:reviews
     */
    public function userReview($user, $catProd) {
        $qb = $this->createQueryBuilder('rp')
            ->addSelect('rp')
            ->join('rp.rate', 'r')
            ->addSelect('r')
            ->where('rp.user = :user')
            ->andWhere('rp.categoryProduct = :catProd')
            ->setParameters(['user' => $user, 'catProd' => $catProd]);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /*
     * User:Product:reviews
     */
    public function prodReviews(CategoryProduct $categoryProduct) {
        $qb = $this->createQueryBuilder('rp')
            ->addSelect('rp')
            ->join('rp.rate', 'r')
            ->addSelect('r')
            ->join('rp.user', 'u')
            ->addSelect('u')
            ->where('rp.categoryProduct = :catProd')
            ->setParameter('catProd', $categoryProduct);

        return $qb->getQuery();
    }
    
    /*
     * Main:Product:product
     */
    public function getUserLastReviews($user,$product,$limit){
        
        $parameters = array('user'=>$user,'product'=>$product);
        
        $qb = $this->_em->createQueryBuilder();
        $qb->select('rp')
            ->from('ABOMainBundle:RatingProduct', 'rp')
            ->join('rp.rate', 'r')
            ->addSelect('r')
            ->join('rp.user', 'u')
            ->addSelect('u')
            ->where('rp.user != :user')
            ->andWhere('rp.categoryProduct = :product')
            ->orderBy('rp.date')
            ->setMaxResults($limit)
            ->setParameters($parameters);
        
        return $qb->getQuery()->getResult();
    }
}
