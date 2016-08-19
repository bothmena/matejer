<?php

namespace ABO\MainBundle\Entity;

use ABO\ShopBundle\Entity\Shop;
use Doctrine\ORM\EntityRepository;

/**
 * ProductsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductShopRepository extends EntityRepository{

    /*
     * Main:API:userData
     */
    public function getLightShopProducts($shop){
        $qb = $this->createQueryBuilder('ps')
            ->addSelect('ps')
            ->join('ps.categoryProduct', 'cp')
            ->addSelect('cp')
            ->join('cp.product', 'p')
            ->addSelect('p')
            ->where('ps.shop = :shop')
            ->setParameter('shop', $shop);

        return $qb->getQuery()->getResult();
    }
    
    /*
     * Main:Gallery:galleryProduct
     */
    public function getShopProducts($shop){
        $qb = $this->createQueryBuilder('ps')
            ->addSelect('ps')
            ->join('ps.categoryProduct', 'cp')
            ->addSelect('cp')
            ->join('cp.product', 'p')
            ->addSelect('p')
            ->join('cp.category', 'c')
            ->addSelect('c')
            ->join('cp.image', 'i')
            ->addSelect('i')
            ->join('cp.rateStat', 'r')
            ->addSelect('r')
            ->join('cp.generalSpecs', 'g')
            ->addSelect('g')
            ->leftJoin('cp.shop', 's')
            ->addSelect('s')
            ->leftJoin('s.image', 'si')
            ->addSelect('si')
            ->leftJoin('cp.trademark', 't')
            ->addSelect('t')
            ->leftJoin('t.image', 'ti')
            ->addSelect('ti')
            ->where('ps.shop = :shop')
            ->setParameter('shop', $shop);

        return $qb->getQuery();
    }
    
    /*
     * Main:Modal:offerInfo => to be deleted -> use CollectionProduct / PaymentProduct instead
     */
    public function getSinglePS($id){
        $qb = $this->createQueryBuilder('ps')
            ->addSelect('ps')
            ->join('ps.shop', 's')
            ->addSelect('s')
            ->join('ps.categoryProduct', 'cp')
            ->addSelect('cp')
            ->join('cp.category', 'c')
            ->addSelect('c')
            ->leftJoin('cp.generalSpecs', 'g')
            ->addSelect('g')
            ->leftJoin('cp.rateStat', 'r')
            ->addSelect('r')
            ->leftJoin('cp.product', 'p')
            ->addSelect('p')
            ->where('ps.id = :id')
            ->setParameter('id', $id);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /*
     * Main:Modal:offerInfo => to be deleted -> use CollectionProduct / PaymentProduct instead
     */
    public function getPSBySlug($slug, Shop $shop){
        $qb = $this->createQueryBuilder('ps')
            ->addSelect('ps')
            ->join('ps.shop', 's')
            ->addSelect('s')
            ->join('ps.categoryProduct', 'cp')
            ->addSelect('cp')
            ->join('cp.category', 'c')
            ->addSelect('c')
            ->join('cp.generalSpecs', 'g')
            ->addSelect('g')
            ->join('cp.rateStat', 'r')
            ->addSelect('r')
            ->join('cp.product', 'p')
            ->addSelect('p')
            ->leftJoin('cp.image', 'i')
            ->addSelect('i')
            ->where('p.slug = :slug')
            ->andWhere('ps.shop = :shop')
            ->setParameters( ['slug'=>$slug, 'shop'=>$shop] );

        return $qb->getQuery()->getOneOrNullResult();
    }
    
    /*
     * Main:Modal:ShopInfo
     */
    public function countPSByCategory($shop,$category) {
        
        $parameters = array('shop'=>$shop,'category'=>$category);
        
        $qb = $this->createQueryBuilder('ps')
            ->addSelect('ps')
            ->select('COUNT(ps)')
            ->join('ps.categoryProduct', 'cp')
            ->join('cp.category', 'c')
            ->where('ps.shop = :shop')
            ->andWhere('c.parent = :category')
            ->setParameters($parameters);

        return $qb->getQuery()->getSingleScalarResult();
    }
    
    /*
     * shop:productAdmin | product :prodByCategory
     */
    public function getPSByCategory($shop,$category){
        
        $parameters = array('shop'=>$shop,'category'=>$category);
        
        $qb = $this->createQueryBuilder('ps')
            ->addSelect('ps')
            ->join('ps.categoryProduct', 'cp')
            ->addSelect('cp')
            ->join('cp.product', 'p')
            ->addSelect('p')
            ->join('cp.category', 'c')
            ->addSelect('c')
            ->join('cp.image', 'i')
            ->addSelect('i')
            ->join('cp.rateStat', 'r')
            ->addSelect('r')
            ->join('cp.generalSpecs', 'g')
            ->addSelect('g')
            ->leftJoin('cp.shop', 's')
            ->addSelect('s')
            ->leftJoin('s.image', 'si')
            ->addSelect('si')
            ->leftJoin('cp.trademark', 't')
            ->addSelect('t')
            ->leftJoin('t.image', 'ti')
            ->addSelect('ti')
            ->where('ps.shop = :shop')
            ->andWhere('cp.category = :category')
            ->setParameters($parameters);
         
        return $qb->getQuery();
    }

    /*
     * Main:Gallery:galleryOffer
     */
    public function getAllPS(){
         $qb = $this->createQueryBuilder('ps')
            ->addSelect('ps')
            ->join('ps.categoryProduct', 'cp')
            ->addSelect('cp')
            ->join('cp.product', 'p')
            ->addSelect('p')
            ->join('cp.category', 'ca')
            ->addSelect('ca')
            ->leftJoin('cp.generalSpecs', 'g')
            ->addSelect('g')
            ->leftJoin('cp.image', 'i')
            ->addSelect('i')
            ->leftJoin('cp.rateStat', 'r')
            ->addSelect('r')
            ->where('ps.availability != :aval')
            ->setParameter('aval', 'unava');
         
        return $qb->getQuery()
            ->getResult();
    }
    
    /*
     * Main:Gallery:galleryOffer
     */
    public function searchPS($nom){
        
        $qb = $this->createQueryBuilder('ps');
         
        $qb->addSelect('ps')
            ->join('ps.categoryProduct', 'cp')
            ->addSelect('cp')
            ->join('cp.product', 'p')
            ->addSelect('p')
            ->join('ps.shop', 's')
            ->addSelect('s')
            ->leftJoin('cp.category', 'ca')
            ->addSelect('ca')
            ->leftJoin('cp.generalSpecs', 'g')
            ->addSelect('g')
            ->leftJoin('cp.image', 'i')
            ->addSelect('i')
            ->leftJoin('cp.rateStat', 'r')
            ->addSelect('r')
            ->where('ps.availability != :quant')
            ->andWhere($qb->expr()->orX(
                $qb->expr()->like('p.reference', ':nom'),
                $qb->expr()->like('p.name', ':nom'),
                $qb->expr()->like('s.name', ':nom')
            ))
            ->setParameter('quant', 'unava')
            ->setParameter('nom', '%'.$nom.'%');
         
        return $qb->getQuery()
            ->getResult();
    }
    
    /*
     * Shop:Show:homeadmin
     */
    public function getLastPS($shop,$mr){
        $qb = $this->createQueryBuilder('ps')
            ->addSelect('ps')
            ->join('ps.categoryProduct', 'cp')
            ->addSelect('cp')
            ->join('cp.product', 'p')
            ->addSelect('p')
            ->where('ps.shop = :shop')
            ->orderBy('ps.date','DESC')
            ->setMaxResults($mr)
            ->setParameter('shop', $shop);
        return $qb->getQuery()
            ->getResult();
    }
    
    /*
     * Shop:Show:homeadmin | home
     */
    public function getPSNb($shop) {
        
        $qb = $this->createQueryBuilder('ps')
            ->addSelect('ps')
            ->select('COUNT(ps)')
            ->where('ps.shop = :shop')
            ->setParameter('shop', $shop);

        return $qb->getQuery()->getSingleScalarResult();
    }
}