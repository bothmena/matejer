<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ABO\MainBundle\Services;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;

class ABOFileLoader extends \Twig_Extension {
    
    private $cm;
    private $dm;
    private $fm;
    
    public function __construct(CacheManager $cManager, DataManager $dm, FilterManager $fm) {
        
        $this->cm = $cManager;
        $this->dm = $dm;
        $this->fm = $fm;
    }
    
    public function getImage( $path, $filter, $gcs ) {
        
        if($gcs){
            return $this->getGCSPath($path, $filter);
        }
        
        if($this->cm->isStored($path, $filter))
            $url = $this->cm->getBrowserPath($path, $filter);
        else
            $url = $this->applyFilter($path, $filter);
        
        return $url;
        //return str_replace ( 'http://' , 'https://', $url );
    }
    
    public function getImageWebPath( $path, $filter ) {
        
        if($this->cm->isStored($path, $filter))
            $url = $this->cm->getBrowserPath($path, $filter);
        else
            $url = $this->applyFilter($path, $filter);
        
        return $url;
        //return str_replace ( 'http://www.matejer.com' , '', $url );
    }
    
    private function applyFilter($path, $filter) {
        
        $binary = $this->dm->find($filter, $path);
        $filteredBinary = $this->fm->applyFilter($binary, $filter);
        $this->cm->store($filteredBinary, $path, $filter);
        return $this->cm->resolve($path, $filter);
    }
    
    private function getGCSPath( $path, $filter ) {
        
        return 'https://matejer.storage.googleapis.com/media/cache/' . $filter . '/' . $path;
        
    }
    
    public function getFunctions() {
        
        return array(
            'get_image' => new \Twig_SimpleFunction('get_image', array($this, 'getImage') ),
        );
    }
    
    public function getName() {
        
        return 'ABOFileLoader';
    }
}
