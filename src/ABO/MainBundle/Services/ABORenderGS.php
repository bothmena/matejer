<?php

namespace ABO\MainBundle\Services;

use ABO\MainBundle\Entity\GeneralSpec;
use Symfony\Component\Translation\DataCollectorTranslator;

class ABORenderGS extends \Twig_Extension {

    /** @var DataCollectorTranslator $translator */
    protected $translator;
    protected $loader;
    private $clothes = ['TopMan', 'BottomMan', 'ShoesMan', 'TopWoman', 'BottomWoman', 'ShoesWoman',
        'UnderwearWoman','TopBoy', 'BottomBoy', 'ShoesBoy', 'TopGirl', 'BottomGirl',
        'ShoesGirl', 'TopBaby', 'BottomBaby', 'ShoesBaby'];

/* Storage, Camcorder, Camera, Projector, Console, Book, Auto, Moto,  */
    
    public function __construct($translator, ABOFileLoader $loader) {

        $this->translator = $translator;
        $this->loader = $loader;
    }
    
    public function renderGS(GeneralSpec $genSpec) {

        return $this->render($this->gsToArray($genSpec));
    }

    public function descGS(GeneralSpec $genSpec, $length = 155 ){

        $gsArray = $this->gsToArray($genSpec);
        if(!empty($gsArray['description'])){
            return $this->cutString( $gsArray['description'], $length);
        }
        else if ( !empty($gsArray['specs']) ) {
            $msg = '';
            foreach ( $gsArray['specs'] as $key => $val ){
                if(is_array($val) ){
                    $msg .= $key;
                    foreach ($val as $subVal){
                        $msg .= $subVal . ', ';
                    }
                }else
                    $msg .= $key . ': ' . $val . '; ';
            }
            return $this->cutString( $msg, $length );
        }
    }

    private function cutString($str, $length) {

        if( mb_strlen($str, 'utf8') < $length )
            return $str;
        else{
            $str = substr( $str, 0, $length - 4 );
            $str = substr( $str, 0, strrpos($str, ' ') + 1 );
            return $str . '...';
        }
    }

    private function gsToArray(GeneralSpec $genSpec){

        if(in_array($genSpec->getSpecsClass(), $this->clothes)){
            return $this->clothesGS($genSpec);
        }
        else{
            switch ($genSpec->getSpecsClass()) {
                case 'Standard':
                    return $this->getStandard($genSpec);
                case 'Television':
                    return $this->getTelevision($genSpec);
                case 'PhoneTablet':
                    return $this->getPhoneTablet($genSpec);
                case 'Computer':
                    return $this->getComputer($genSpec);
                case 'Monitor':
                    return $this->getMonitor($genSpec);
                case 'GraphicCard':
                    return $this->getGraphicCard($genSpec);
                case 'Motherboard':
                    return $this->getMotherboard($genSpec);
                case 'Processor':
                    return $this->getProcessor($genSpec);
                case 'Ram':
                    return $this->getRam($genSpec);
                default:
                    return $this->getStandard($genSpec);
            }
        }
    }

    private function render(array $gsArray){

        $html = '';
        if(!empty($gsArray['description']))
            $html .= '<tr><th colspan="2">' . $this->translator->trans('matejer_genspecs.description') . '</th></tr><tr><td colspan="2">'. $gsArray['description'] .'</td></tr>';
        if(!empty($gsArray['specs'])){
            foreach ($gsArray['specs'] as $key => $spec ){
                $html .= $this->renderSpec($key, $spec);
            }
        }
        if(!empty($gsArray['sizes'])){
            $html .= '<tr><th>' . $this->translator->trans('matejer_genspecs.sizes') . '</th><td>';
            foreach ($gsArray['sizes'] as $key => $sizes ){
                foreach ($sizes as $size)
                    $html .= '<div class="prod-size" title="'. $this->translator->trans($key) .'" data-toggle="tooltip">' . $size . '</div>';
                $html .= '<br>';
            }
            $html .= '</td></tr>';
        }
        if(!empty($gsArray['colors'])){
            $html .= '<tr><th>' . $this->translator->trans('matejer_genspecs.colors') . '</th><td>';
            foreach ($gsArray['colors'] as $color ){
                $html .= '<div class="prod-color" style="background-color: #'. $color .';"></div>';
            }
            $html .= '</td></tr>';
        }
        if(!empty($gsArray['care'])){
            $html .= '<tr><th>' . $this->translator->trans('matejer_genspecs.care') . '</th><td><ul class="thumbnails image_picker_selector cgs">';
            foreach ($gsArray['care'] as $title=>$img ){
                $html .= '<li><div class="thumbnail" data-toggle="tooltip" title="'.$title.'"><img src="'. $this->loader->getImage($img, "clothegs") .'" class="image_picker_image"></div></li>';
            }
            $html .= '</ul></td></tr>';
        }
        return $html;
    }
    
    private function renderSpec( $key, $spec ){

        if(is_array($spec) ){
            $str = '<tr><th colspan="2">'. $key .' :</th></tr><tr><td colspan="2">';
            foreach ($spec as $subSpec){
                $str .= '- '.$subSpec.'<br>';
            }
            return $str.'</td></tr>';
        }else
            return '<tr><th>'. $key .'</th><td>'. $spec .'</td></tr>';;
    }

    private function clothesGS(GeneralSpec $genSpec){

        return array(
            'description'=>$genSpec->getDescription(),
            'sizes' => $this->getSizes($genSpec->getTen()),
            'care' => $this->getLaundryCare($genSpec),
            'colors' => empty( $genSpec->getColors() ) ? [] : explode("#", $genSpec->getColors()),
        );
    }

    private function getTelevision(GeneralSpec $genSpec) {

        return array(
            'description'=>'',
            'colors' => empty( $genSpec->getColors() ) ? [] : explode("#", $genSpec->getColors()),
            'specs' => array(
                $this->translator->trans('matejer_genspecs.Television.one.label') => $genSpec->getOne().' '.$this->translator->trans('matejer_genspecs.Television.one.unit'),
                $this->translator->trans('matejer_genspecs.Television.two_three.label') => $this->resolution( $genSpec->getTwo(), $genSpec->getThree() ),
                $this->translator->trans('matejer_genspecs.Television.four.label') => $this->translator->trans( 'matejer_genspecs.Television.four.values.'.$genSpec->getFour() ),
                $this->translator->trans('matejer_genspecs.Television.ten.label') => $genSpec->getTen(),
                $this->translator->trans('matejer_genspecs.Television.five.label') => $genSpec->getFive().' '.$this->translator->trans('matejer_genspecs.Television.five.unit'),
                $this->translator->trans('matejer_genspecs.Television.six.label') => $this->yesOrNo($genSpec->getSix()),
                $this->translator->trans('matejer_genspecs.Television.seven.label') => $this->yesOrNo($genSpec->getSeven()),
                $this->translator->trans('matejer_genspecs.Television.eight.label') => $genSpec->getEight(),
                $this->translator->trans('matejer_genspecs.Television.nine.label') => $genSpec->getNine(),
            ));
    }

    private function getPhoneTablet(GeneralSpec $genSpec) {

        return array(
            'description'=>'',
            'colors' => empty( $genSpec->getColors() ) ? [] : explode("#", $genSpec->getColors()),
            'specs' => array(
                $this->translator->trans('matejer_genspecs.PhoneTablet.one.label') => $genSpec->getOne(),
                $this->translator->trans('matejer_genspecs.PhoneTablet.two.label') => $this->mBToGB($genSpec->getTwo()),
                $this->translator->trans('matejer_genspecs.PhoneTablet.three.label') => $genSpec->getThree().' '.$this->translator->trans('matejer_genspecs.PhoneTablet.three.unit'),
                $this->translator->trans('matejer_genspecs.PhoneTablet.four_five.label') => $genSpec->getFour().'x'.$genSpec->getFive().' '.$this->translator->trans('matejer_genspecs.PhoneTablet.four_five.unit'),
                $this->translator->trans('matejer_genspecs.PhoneTablet.six.label') => $this->translator->trans('matejer_genspecs.PhoneTablet.six.values.'.$genSpec->getSix()),
                $this->translator->trans('matejer_genspecs.PhoneTablet.seven.label') => $genSpec->getSeven().' '.$this->translator->trans('matejer_genspecs.PhoneTablet.seven.unit'),
                $this->translator->trans('matejer_genspecs.PhoneTablet.eight.label') => $genSpec->getEight().' '.$this->translator->trans('matejer_genspecs.PhoneTablet.eight.unit'),
                $this->translator->trans('matejer_genspecs.PhoneTablet.nine.label') => $genSpec->getNine().' '.$this->translator->trans('matejer_genspecs.PhoneTablet.nine.unit'),
                $this->translator->trans('matejer_genspecs.PhoneTablet.ten.label') => $this->translator->trans('matejer_genspecs.PhoneTablet.ten.value', array('%storage%'=>$genSpec->getTen())),
            ));
    }

    private function getComputer(GeneralSpec $genSpec) {

        return array(
            'description'=>'',
            'colors' => empty( $genSpec->getColors() ) ? [] : explode("#", $genSpec->getColors()),
            'specs' => array(
                $this->translator->trans('matejer_genspecs.Computer.one.label') => $genSpec->getOne(),
                $this->translator->trans('matejer_genspecs.Computer.two.label') => $genSpec->getTwo() . ' ' . $this->translator->trans('matejer_genspecs.Computer.two.unit'),
                $this->translator->trans('matejer_genspecs.Computer.three.label') => $genSpec->getThree(),
                $this->translator->trans('matejer_genspecs.Computer.four.label') => $genSpec->getFour(),
                $this->translator->trans('matejer_genspecs.Computer.five.label') => $genSpec->getFive(),
                $this->translator->trans('matejer_genspecs.Computer.six.label') => $genSpec->getSix(). ' ' . $this->translator->trans('matejer_genspecs.Computer.six.unit'),
                $this->translator->trans('matejer_genspecs.Computer.seven_eight.label') => $this->resolution($genSpec->getSeven(), $genSpec->getEight()),
                $this->translator->trans('matejer_genspecs.Computer.nine.label') => $this->yesOrNo($genSpec->getNine()),
            ));
    }

    private function getMonitor(GeneralSpec $genSpec) {

        return array(
            'description'=>'',
            'colors' => empty( $genSpec->getColors() ) ? [] : explode("#", $genSpec->getColors()),
            'specs' => array(
                $this->translator->trans('matejer_genspecs.Monitor.one.label') => $genSpec->getOne().' '.$this->translator->trans('matejer_genspecs.Monitor.one.unit'),
                $this->translator->trans('matejer_genspecs.Monitor.two_three.label') => $this->resolution($genSpec->getTwo(), $genSpec->getThree()),
                $this->translator->trans('matejer_genspecs.Monitor.four.label') => $this->translator->trans('matejer_genspecs.Monitor.four.values.'.$genSpec->getFour()),
                $this->translator->trans('matejer_genspecs.Monitor.five.label') => $genSpec->getFive(),
                $this->translator->trans('matejer_genspecs.Monitor.six.label') => $genSpec->getSix().' '.$this->translator->trans('matejer_genspecs.Monitor.six.unit'),
                $this->translator->trans('matejer_genspecs.Monitor.seven.label') => $genSpec->getSeven().':1',
                $this->translator->trans('matejer_genspecs.Monitor.eight.label') => $genSpec->getEight().' '.$this->translator->trans('matejer_genspecs.Monitor.eight.unit'),
                $this->translator->trans('matejer_genspecs.Monitor.nine.label') => explode("#", $genSpec->getNine()),
            ));
    }

    private function getRam(GeneralSpec $genSpec) {

        return array(
            'description'=>'',
            'colors' => empty( $genSpec->getColors() ) ? [] : explode("#", $genSpec->getColors()),
            'specs' => array(
                $this->translator->trans('matejer_genspecs.Ram.one.label') => $genSpec->getOne(),
                $this->translator->trans('matejer_genspecs.Ram.two.label') => $genSpec->getTwo().' '.$this->translator->trans('matejer_genspecs.Ram.two.unit'),
                $this->translator->trans('matejer_genspecs.Ram.three.label') => $genSpec->getThree().' '.$this->translator->trans('matejer_genspecs.Ram.three.unit'),
                $this->translator->trans('matejer_genspecs.Ram.four.label') => $genSpec->getFour(),
            ));
    }

    private function getGraphicCard(GeneralSpec $genSpec) {

        return array(
            'description'=>'',
            'colors' => empty( $genSpec->getColors() ) ? [] : explode("#", $genSpec->getColors()),
            'specs' => array(
                $this->translator->trans('matejer_genspecs.GraphicCard.one.label') => $genSpec->getOne(),
                $this->translator->trans('matejer_genspecs.GraphicCard.two.label') => $genSpec->getTwo(),
                $this->translator->trans('matejer_genspecs.GraphicCard.three.label') => $genSpec->getThree(),
                $this->translator->trans('matejer_genspecs.GraphicCard.four.label') => $genSpec->getFour(),
                $this->translator->trans('matejer_genspecs.GraphicCard.five.label') => $genSpec->getFive().' '.$this->translator->trans('matejer_genspecs.GraphicCard.five.unit'),
                $this->translator->trans('matejer_genspecs.GraphicCard.six.label') => $genSpec->getSix().' '.$this->translator->trans('matejer_genspecs.GraphicCard.six.unit'),
            ));
    }

    private function getMotherboard(GeneralSpec $genSpec) {

        return array(
            'description'=>'',
            'colors' => empty( $genSpec->getColors() ) ? [] : explode("#", $genSpec->getColors()),
            'specs' => array(
                $this->translator->trans('matejer_genspecs.Motherboard.one.label') => $genSpec->getOne(),
                $this->translator->trans('matejer_genspecs.Motherboard.two.label') => $genSpec->getTwo(),
                $this->translator->trans('matejer_genspecs.Motherboard.three.label') => $genSpec->getThree(),
                $this->translator->trans('matejer_genspecs.Motherboard.four.label') => $genSpec->getFour(),
                $this->translator->trans('matejer_genspecs.Motherboard.five.label') => $genSpec->getFive().' '.$this->translator->trans('matejer_genspecs.Motherboard.five.unit'),
                $this->translator->trans('matejer_genspecs.Motherboard.six.label') => explode("#", $genSpec->getSix()),
                $this->translator->trans('matejer_genspecs.Motherboard.seven.label') => explode("#", $genSpec->getSeven()),
                $this->translator->trans('matejer_genspecs.Motherboard.eight.label') => explode("#", $genSpec->getEight()),
                $this->translator->trans('matejer_genspecs.Motherboard.nine.label') => explode("#", $genSpec->getNine()),
            ));
    }

    private function getProcessor(GeneralSpec $genSpec) {

        return array(
            'description'=>'',
            'colors' => empty( $genSpec->getColors() ) ? [] : explode("#", $genSpec->getColors()),
            'specs' => array(
                $this->translator->trans('matejer_genspecs.Processor.one.label') => $genSpec->getOne(),
                $this->translator->trans('matejer_genspecs.Processor.two.label') => $this->mBToGB($genSpec->getTwo()),
                $this->translator->trans('matejer_genspecs.Processor.three.label') => $genSpec->getThree().' '.$this->translator->trans('matejer_genspecs.Processor.three.unit'),
                $this->translator->trans('matejer_genspecs.Processor.four.label') => $genSpec->getFour().' '.$this->translator->trans('matejer_genspecs.Processor.four.unit'),
                $this->translator->trans('matejer_genspecs.Processor.five.label') => $genSpec->getFive().' '.$this->translator->trans('matejer_genspecs.Processor.five.unit'),
                $this->translator->trans('matejer_genspecs.Processor.six.label') => $genSpec->getSix(),
                $this->translator->trans('matejer_genspecs.Processor.seven.label') => $genSpec->getSeven().' '.$this->translator->trans('matejer_genspecs.Processor.seven.unit'),
                $this->translator->trans('matejer_genspecs.Processor.eight.label') => $genSpec->getEight(),
            ));
    }

    private function getStandard(GeneralSpec $genSpec) {

        return array(
            'description'=> $genSpec->getDescription(),
            'colors' => empty( $genSpec->getColors() ) ? [] : explode("#", $genSpec->getColors()),
            'specs' => array(),
        );
    }

    private function yesOrNo($value){
        return $value == 1 ? $this->translator->trans('matejer_main.yes') : $this->translator->trans('matejer_main.no');
    }

    private function resolution($width, $height){
        if($width == 1360 && $height == 768)
            return $this->translator->trans('resolution.hd').' '. $width. 'x' . $height.' '.$this->translator->trans('resolution.pixels');
        else if($width == 1920 && $height == 1080)
            return $this->translator->trans('resolution.fhd').' '. $width. 'x' . $height.' '.$this->translator->trans('resolution.pixels');
        else if($width == 2560 && $height == 1440)
            return $this->translator->trans('resolution.qhd').' '. $width. 'x' . $height.' '.$this->translator->trans('resolution.pixels');
        else if($width == 3840 && $height == 2160)
            return $this->translator->trans('resolution.4k').' '. $width. 'x' . $height.' '.$this->translator->trans('resolution.pixels');
        else if($width == 5120 && $height == 2880)
            return $this->translator->trans('resolution.5k').' '. $width. 'x' . $height.' '.$this->translator->trans('resolution.pixels');
        else if($width == 7680 && $height == 4320)
            return $this->translator->trans('resolution.8k').' '. $width. 'x' . $height.' '.$this->translator->trans('resolution.pixels');
        else
            return $width. 'x' . $height.' '.$this->translator->trans('resolution.pixels');
    }

    private function mBToGB($value){
        if($value % 1024 === 0)
            return $value/1024 .' '.$this->translator->trans('matejer_main.go');
        else
            return $value.' '.$this->translator->trans('matejer_main.mo');
    }

    private function getSizes($strSizes){

        $arr = explode("#", $strSizes); $sizes = [];
        $lastGroup = '';
        foreach ($arr as $size) {
            if(in_array( $size, ['uni', 'fr', 'age', 'eur'] )) {
                $size = 'matejer_size.' . $size;
                $sizes[$size] = [];
                $lastGroup = $size;
            }
            else
                array_push($sizes[$lastGroup], $size);
        }
        return $sizes;
    }

    private function getLaundryCare(GeneralSpec $genSpec){

        $vars = ['one'=>$genSpec->getOne(), 'two'=>$genSpec->getTwo(), 'three'=>$genSpec->getThree(), 'four'=>$genSpec->getFour(),
            'five'=>$genSpec->getFive(), 'six'=>$genSpec->getSix(), 'seven'=>$genSpec->getSeven(), 'eight'=>$genSpec->getEight(), 'nine'=>$genSpec->getNine()];
        $arr = [];
        foreach ($vars as $key => $var){
            if (!empty($var))
                $arr[$this->translator->trans('matejer_genspecs.ClotheGS.' . $key . '.' . $var . '.title')]
                    = '/images/clothe-care/' . $var . '.png';
        }
        return $arr;
    }
    
    public function getFunctions() {
        
        return array(
            'renderGS' => new \Twig_SimpleFunction('renderGS', array($this, 'renderGS') ),
            'descGS' => new \Twig_SimpleFunction('descGS', array($this, 'descGS') ),
        );
    }
    
    public function getName() {
        
        return 'ABORenderGS';
    }
}
