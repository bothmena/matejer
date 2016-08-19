<?php

/**
 * Created by PhpStorm.
 * User: aymen
 * Date: 29/04/16
 * Time: 19:56
 */

namespace ABO\AdminBundle\Command;

use ABO\MainBundle\Entity\Image;
use ABO\MainBundle\Services\ABOFileLoader;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImageListCommand extends Command {

    protected $em;
    private $loader;

    public function __construct(EntityManager $entityManager, ABOFileLoader $loader) {

        $this->em = $entityManager;
        $this->loader = $loader;
        parent::__construct();
    }

    protected function configure() {

        $this
            ->setName('abo:image:list')
            ->setDescription('List all images that need to be uploaded to gcs.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output ) {

        $file = fopen("image_listing.txt", "w") or die("Unable to open file!");
        $images = $this->em->getRepository('ABOMainBundle:Image')->findBy(array('gcs'=>false));
        
        foreach ($images as $image){
            /* @var $image Image */
            fwrite($file, $image->getId()."\n");
            switch ( $image->getEntity() ){
                case 'user':
                    $this->userImages($file, $image);
                    break;
                case 'trademark':
                    $this->tmImages($file, $image);
                    break;
                case 'shop':
                    $this->shopImages($file, $image);
                    break;
                case 'product':
                    $this->prodImages($file, $image);
                    break;
                /*case 'website':
                    $this->websiteImages($file, $image);
                    break;*/
            }
            fwrite($file, '/' . $image->getSource()."\n");
        }
        fwrite($file, "0\n");
        fclose($file);

        $output->writeln('job accomplished, check /matejer.com/image_listing.txt');
    }
    
    private function userImages($file, Image $image) {
        
        $path = $this->loader->getImageWebPath($image->getSource(), 'dash_logo');
        fwrite($file, $path."\n");
        $path = $this->loader->getImageWebPath($image->getSource(), 'avatar');
        fwrite($file, $path."\n");
    }
    
    private function tmImages($file, Image $image) {
        
        if($image->getType() === 'profile'){
            $path = $this->loader->getImageWebPath($image->getSource(), 'dash_logo');
            fwrite($file, $path."\n");
            $path = $this->loader->getImageWebPath($image->getSource(), 'icon_logo');
            fwrite($file, $path."\n");
        }
        else if($image->getType() === 'feature'){
            $path = $this->loader->getImageWebPath($image->getSource(), 'prod_modal');
            fwrite($file, $path."\n");
            $path = $this->loader->getImageWebPath($image->getSource(), 'mini_cover');
            fwrite($file, $path."\n");
        }
    }
    
    private function shopImages($file, Image $image) {
        
        if($image->getType() === 'profile'){
            $path = $this->loader->getImageWebPath($image->getSource(), 'dash_logo');
            fwrite($file, $path."\n");
            $path = $this->loader->getImageWebPath($image->getSource(), 'icon_logo');
            fwrite($file, $path."\n");
            $path = $this->loader->getImageWebPath($image->getSource(), 'avatar');
            fwrite($file, $path."\n");
        }
        else if($image->getType() === 'cover'){
            $path = $this->loader->getImageWebPath($image->getSource(), 'm_gallery_thumb');
            fwrite($file, $path."\n");
            $path = $this->loader->getImageWebPath($image->getSource(), 'cover');
            fwrite($file, $path."\n");
            $path = $this->loader->getImageWebPath($image->getSource(), 'mini_cover');
            fwrite($file, $path."\n");
        }
    }
    
    private function prodImages($file, Image $image) {
        
        $path = $this->loader->getImageWebPath($image->getSource(), 'prod_gallery');
        fwrite($file, $path."\n");
        if( $image->getType() === 'primary' ){
            $path = $this->loader->getImageWebPath($image->getSource(), 'gallery_thumb');
            fwrite($file, $path."\n");
            $path = $this->loader->getImageWebPath($image->getSource(), 'prod_modal');
            fwrite($file, $path."\n");
        }
    }
    
    /*private function websiteImages($file, Image $image) {
        
        if ( $image->getId() === 4 ){
            $path = $this->loader->getImageWebPath($image->getSource(), 'm_gallery_thumb');
            fwrite($file, $path."\n");
            $path = $this->loader->getImageWebPath($image->getSource(), 'cover');
            fwrite($file, $path."\n");
            //logo
            $path = $this->loader->getImageWebPath('images/logo.png', 'icon_logo');
            fwrite($file, $path."\n");
            $path = $this->loader->getImageWebPath('images/logo.png', 'avatar');
            fwrite($file, $path."\n");
        }else{
            $path = $this->loader->getImageWebPath($image->getSource(), 'dash_logo');
            fwrite($file, $path."\n");
            $path = $this->loader->getImageWebPath($image->getSource(), 'icon_logo');
            fwrite($file, $path."\n");
            $path = $this->loader->getImageWebPath($image->getSource(), 'avatar');
            fwrite($file, $path."\n");
        }
    }*/
}
