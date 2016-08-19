<?php

namespace ABO\MainBundle\Services;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

class ABOUtil {
    
    protected $translator;

    public function __construct($translator) {
        
        $this->translator = $translator;
    }
    
    public function ficheToArray($fiches) {
        
        $ficheArray = [];
        foreach ($fiches as $fiche) {
            if(empty($ficheArray[$fiche->getGroup()]))
                $ficheArray[ $fiche->getGroup() ] = array(
                    'type'=>$fiche->getType(),
                    'fiches'=>[],
                );
            if($fiche->getType() === 'simple')
                array_push($ficheArray[ $fiche->getGroup() ]['fiches'], $fiche->getValue());
            else
                $ficheArray[ $fiche->getGroup() ]['fiches'][ $fiche->getName() ] = $fiche->getValue();
        }
        return $ficheArray;
    }
    
    public function getName() {
        
        return 'ABOUtil';
    }
}
