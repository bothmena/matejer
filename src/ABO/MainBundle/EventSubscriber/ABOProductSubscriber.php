<?php

namespace ABO\MainBundle\EventSubscriber;

use ABO\MainBundle\Entity\CategoryProduct;
use ABO\MainBundle\Entity\FeatureProduct;
use ABO\MainBundle\Entity\ImageProduct;
use ABO\MainBundle\Entity\ProductColor;
use ABO\MainBundle\Entity\ProductShop;
use ABO\MainBundle\Entity\ProductSize;
use ABO\MainBundle\Entity\TagProduct;
use ABO\MainBundle\Event\ValidProductSubmissionEvent;
use ABO\MainBundle\Event\ValidSpecificationSubmissionEvent;
use ABO\MainBundle\Services\ABOFileUploader;
use ABO\MainBundle\Services\ABOUniqueness;
use ABO\ShopBundle\Entity\Shop;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Form;

class ABOProductSubscriber implements EventSubscriberInterface {
    
    private $em;
    private $unique;
    private $uploader;
    private $tags = array();

    public function __construct(EntityManager $em, ABOUniqueness $unique, ABOFileUploader $uploader){
        
        $this->em = $em;
        $this->unique = $unique;
        $this->uploader = $uploader;
    }
    
    public static function getSubscribedEvents() {
        // return the subscribed events, their methods and priorities
        return array(
           'abo.valid_product_submission' => array(
               array('onValidProductSubmission'),
           ),
           'abo.valid_specification_submission' => array(
               array('onValidSpecificationSubmission'),
           ),
        );
    }

    public function onValidProductSubmission(ValidProductSubmissionEvent $event) {
    
        $catProd = $event->getCategoryProduct();
        $form = $event->getForm();
        $this->em->persist($catProd);

        $this->tags['category'] = array(
            $catProd->getCategory()->getSlug(),
            $catProd->getCategory()->getParent()->getSlug(),
            $catProd->getCategory()->getParent()->getParentName()
        );

        if($form->has('size'))
            $this->persistSizes ( $form, $catProd );

        $this->persistColors( $form->get('colors')->getData(), $catProd );
        if($form->has('parentColors'))
            $this->persistParentColors($form->get('parentColors')->getData(), $catProd);
        $this->addClrsToGS($catProd);

        if( $form->has('feature') && !$catProd->getAnyParent() )
            $this->persistFeatures($form->get('feature')->getData(), $catProd);

        if(!$catProd->getAnyParent())
            $this->persistTags($this->tags, $catProd);
        //folder & images
        $folder = $this->unique->getUnique('ABOMainBundle:Product','folder');
        $catProd->getProduct()->setFolder($folder);
        $this->handleImages($form, $folder, $catProd);
        //add new offer if shop not null => shop owner of the product.
        if( $catProd->getShop() ){
            $this->addOffer( $catProd->getShop(), $catProd );
        }
        
        $this->em->flush();
    }

    public function onValidSpecificationSubmission(ValidSpecificationSubmissionEvent $event) {
        
        $catProd = $event->getCategoryProduct();
        $form = $event->getForm();
        $language = $form->get('language')->getData();

        foreach ($form->get('ficheProduct')->getData() as $sF) {

            $sF->setCategoryProduct($catProd);
            $sF->setLanguage($language);
            $this->em->persist($sF);
        }
        
        $this->em->flush();
    }

    private function addOffer( Shop $shop, CategoryProduct $catProd ){

        $offer = new ProductShop();
        $offer->setAvailability('unava');
        $offer->setPrice(0);
        $offer->setCategoryProduct($catProd);
        $offer->setShop( $shop );
        $shop->setOfferNb( $shop->getOfferNb() + 1 );
        $catShop = $this->em->getRepository('ABOShopBundle:CategoryShop')->findOneBy(array(
            'shop'=>$catProd->getShop(), 'category'=>$catProd->getCategory()
        ));
        if($catShop)
            $catShop->setProductNb( $catShop->getProductNb() + 1 );
        $this->em->persist($shop);
        $this->em->persist($offer);
    }
    
    private function persistColors(array $colors, CategoryProduct $catProd) {
        
        $this->tags['color'] = [];
        foreach ($colors as $clr) {
            array_push($this->tags['color'], $clr['code']);
        }
        $colorsEntities = $this->em->getRepository('ABOMainBundle:Color')->findByCode( $this->tags['color'] );
        $this->tags['color'] = [];
        foreach ($colorsEntities as $key => $clr) {
            
            $color[$key] = new ProductColor();
            $color[$key]->setCategoryProduct($catProd);
            $color[$key]->setColor($clr);
            array_push( $this->tags['color'], $clr->getCode() );
            $this->em->persist($color[$key]);
        }
    }

    private function persistParentColors(ArrayCollection $colors, CategoryProduct $catProd) {

        foreach ($colors as $key => $clr) {

            $color[$key] = new ProductColor();
            $color[$key]->setCategoryProduct($catProd);
            $color[$key]->setColor( $clr );
            array_push( $this->tags['color'], $clr->getCode() );
            $this->em->persist( $color[$key] );
        }
    }

    private function addClrsToGS(CategoryProduct $categoryProduct){

        if(!empty( $this->tags['color'] )){
            $clrs = $this->tags['color'][0];
            $l = count( $this->tags['color'] );
            for ( $i = 1; $i < $l; $i++ ){
                $clrs = $clrs . '#' . $this->tags['color'][$i];
            }
            $categoryProduct->getGeneralSpecs()->setColors($clrs);
        }
    }

    private function persistFeatures($features, CategoryProduct $catProd) {
        
        $this->tags['feature'] = [];
        foreach ($features as $key => $feature) {
            
            $ftr[$key] = new FeatureProduct();
            $ftr[$key]->setCategoryProduct($catProd);
            $ftr[$key]->setFeature($feature);
            array_push( $this->tags['feature'], $feature->getSlug() );
            $this->em->persist($ftr[$key]);
        }
    }

    private function persistSizes(Form $form, CategoryProduct $catProd) {
        
        $this->tags['size'] = [];
        $sizes = $form->get('size')->has('fr') ? $form->get('size')->get('fr')->getData() : null;
        if( !empty($sizes) )
            $this->setSizes( $catProd, $sizes, 'fr' );

        $sizes = $form->get('size')->has('uni') ? $form->get('size')->get('uni')->getData() : null;
        if( !empty($sizes) )
            $this->setSizes( $catProd, $sizes, 'uni' );

        $sizes = $form->get('size')->has('eur') ? $form->get('size')->get('eur')->getData() : null;
        if( !empty($sizes) )
            $this->setSizes( $catProd, $sizes, 'eur' );

        $sizes = $form->get('size')->has('age') ? $form->get('size')->get('age')->getData() : null;
        if( !empty($sizes) )
            $this->setSizes( $catProd, $sizes, 'age' );
    }

    private function setSizes(CategoryProduct $product, ArrayCollection $sizes, $type) {

        if( empty( $product->getGeneralSpecs()->getTen() ) )
            $sizeStr = $type;
        else
            $sizeStr = $product->getGeneralSpecs()->getTen() . '#' . $type;
        foreach ( $sizes as $key => $size ) {

            $prodSize[$key] = new ProductSize();
            $prodSize[$key]->setAvailable( true );
            $prodSize[$key]->setCategoryProduct( $product );
            $prodSize[$key]->setSize( $size );
            $this->em->persist( $prodSize[$key] );
            array_push( $this->tags['size'], $size->getSlug() );
            $sizeStr = $sizeStr . '#' . $size->getValue();
        }
        $product->getGeneralSpecs()->setTen( $sizeStr );
    }
    
    private function persistTags($tags, CategoryProduct $catProd) {

        $key = 0;
        foreach ($tags as $type => $tagArray) {

            $tagEntities = $this->em->getRepository('ABOMainBundle:Tag')->findBy(array('type'=>$type,'name'=>$tagArray));

            foreach ($tagEntities as $tagE) {

                $tagProduct[$key] = new TagProduct();
                $tagProduct[$key]->setCategoryProduct($catProd);
                $tagProduct[$key]->setSlugTag($tagE->getSlug());
                $tagProduct[$key]->setTag($tagE);
                if ($tagE->getType() === 'size')
                    $tagProduct[$key]->setStat('A');
                $this->em->persist($tagProduct[$key]);
                $key++;
            }
        }
    }

    private function handleImages(Form $form, $folder, CategoryProduct $catProd) {

        $images = $form->get('image')->has('files') ?
            $this->uploader->handleMultiFile ( $form->get('image')->get('files')->getData(), $folder ) : [];
        $image  = $this->uploader->handleSingleFile( $form->get('image')->get('file' )->getData(), $folder );
        array_push($images, $image);
        foreach ($images as $key => $img){

            $prodImg[$key] = new ImageProduct( $catProd, $img );
            $this->em->persist($prodImg[$key]);
        }
        $catProd->setImage($image);
    }
}
