<?php

namespace ABO\MainBundle\Form\EventListener;

use ABO\MainBundle\Entity\Category;
use ABO\MainBundle\Form\GenSpecs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Description of ChangeAddressFieldSubscriber
 *
 * @author Aymen
 */

class GeneralSpecsSubscriber implements EventSubscriberInterface {

    private $category;
    
    public function __construct(Category $category) {

        $this->category = $category;
    }
    
    public static function getSubscribedEvents() {
        
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
        );
    }
    
    public function onPreSetData(FormEvent $event) {
        
        $form = $event->getForm();
        switch ( $this->category->getSpecsClass() ){

            case  'Standard':
                $form->add('generalSpecs', GenSpecs\StandardType::class);
                break;
            case  'TopMan':
                $form->add('size', GenSpecs\TopManType::class, array('mapped'=>false));
                break;
            case  'BottomMan':
                $form->add('size', GenSpecs\BottomManType::class, array('mapped'=>false));
                break;
            case  'ShoesMan':
                $form->add('size', GenSpecs\ShoesManType::class, array('mapped'=>false));
                break;
            case  'TopWoman':
                $form->add('size', GenSpecs\TopWomanType::class, array('mapped'=>false));
                break;
            case  'BottomWoman':
                $form->add('size', GenSpecs\BottomWomanType::class, array('mapped'=>false));
                break;
            case  'ShoesWoman':
                $form->add('size', GenSpecs\ShoesWomanType::class, array('mapped'=>false));
                break;
            case  'UnderwearWoman':
                $form->add('size', GenSpecs\UnderwearWomanType::class, array('mapped'=>false));
                break;

            case  'Television':
                $form->add('generalSpecs', GenSpecs\TelevisionType::class);
                break;
            case  'Computer':
                $form->add('generalSpecs', GenSpecs\ComputerType::class);
                break;
            case  'PhoneTablet':
                $form->add('generalSpecs', GenSpecs\PhoneTabletType::class);
                break;
            case  'Monitor':
                $form->add('generalSpecs', GenSpecs\MonitorType::class);
                break;

            case  'TopBoy':
                $form->add('size', GenSpecs\TopBoyType::class, array('mapped'=>false));
                break;
            case  'BottomBoy':
                $form->add('size', GenSpecs\BottomBoyType::class, array('mapped'=>false));
                break;
            case  'ShoesBoy':
                $form->add('size', GenSpecs\ShoesBoyType::class, array('mapped'=>false));
                break;
            case  'TopGirl':
                $form->add('size', GenSpecs\TopGirlType::class, array('mapped'=>false));
                break;
            case  'BottomGirl':
                $form->add('size', GenSpecs\BottomGirlType::class, array('mapped'=>false));
                break;
            case  'ShoesGirl':
                $form->add('size', GenSpecs\ShoesGirlType::class, array('mapped'=>false));
                break;
            case  'TopBaby':
                $form->add('size', GenSpecs\TopBabyType::class, array('mapped'=>false));
                break;
            case  'BottomBaby':
                $form->add('size', GenSpecs\BottomBabyType::class, array('mapped'=>false));
                break;
            case  'ShoesBaby':
                $form->add('size', GenSpecs\ShoesBabyType::class, array('mapped'=>false));
                break;

            case  'Camcorder':
                $form->add('generalSpecs', GenSpecs\CamcorderType::class);
                break;
            case  'Camera':
                $form->add('generalSpecs', GenSpecs\CameraType::class);
                break;
            case  'GraphicCard':
                $form->add('generalSpecs', GenSpecs\GraphicCardType::class);
                break;
            case  'Motherboard':
                $form->add('generalSpecs', GenSpecs\MotherboardType::class);
                break;
            case  'Processor':
                $form->add('generalSpecs', GenSpecs\ProcessorType::class);
                break;
            case  'Projector':
                $form->add('generalSpecs', GenSpecs\ProjectorType::class);
                break;
            case  'Ram':
                $form->add('generalSpecs', GenSpecs\RamType::class);
                break;
            default:
                $form->add('generalSpecs', GenSpecs\StandardType::class);
                break;
        }
    }
}
