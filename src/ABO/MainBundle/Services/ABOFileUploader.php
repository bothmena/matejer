<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ABO\MainBundle\Services;

use ABO\MainBundle\Entity\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ABOFileUploader {
    
    private $unique;
    
    public function __construct(ABOUniqueness $unique){
        
        $this->unique = $unique;
    }
    
    public function handleImage(Image $image, $folder, $entity, $type ) {

        if($image->getFileExt()) {
            $image->setEntity($entity);
            $image->setFolder($folder);
            $image->setImage($this->unique->nameImage($folder, $image->getFileExt()));
            $image->setType($type);
            $image->upload();
            return $image;
        }else
            return null;
    }

    public function handleSingleFile(UploadedFile $uploadedFile, $folder, $entity = 'product', $type = 'primary') {

        $ext = $this->getFileExt( $uploadedFile );
        if( $ext ) {
            $image = new Image();
            $image->setImage($this->unique->nameImage( $folder, $ext ));
            $image->setFolder($folder);
            $image->setEntity($entity);
            $image->setType($type);
            $uploadedFile->move($image->getUploadRootDir(), $image->getImage());
            unset($uploadedFile);
            return $image;
        }else
            return null;
    }

    public function handleMultiFile( array $uploadedFiles, $folder, $entity = 'product', $type = 'secondary' ) {

        $upImages = [];
        foreach($uploadedFiles as $uploadedFile) {

            $ext = $this->getFileExt($uploadedFile);
            if( $ext ) {
                $image = new Image();
                $image->setImage($this->unique->nameImage( $folder, $ext ));
                $image->setFolder($folder);
                $image->setEntity($entity);
                $image->setType($type);
                $uploadedFile->move($image->getUploadRootDir(), $image->getImage());
                array_push($upImages, $image);
            }
            unset($uploadedFile);
        }
        return $upImages;
    }

    private function getFileExt(UploadedFile $uploadedFile = null){

        if ($uploadedFile === null) {
            return null;
        }  else {
            $extension = $uploadedFile->guessExtension();
            if(!$extension)
                $extension = 'bin';
            return $extension;
        }
    }
}
