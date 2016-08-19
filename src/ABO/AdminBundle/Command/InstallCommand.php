<?php

/**
 * Created by PhpStorm.
 * User: aymen
 * Date: 29/04/16
 * Time: 19:56
 */

namespace ABO\AdminBundle\Command;

use ABO\AdminBundle\Controller\Categories;
use ABO\AdminBundle\Controller\Places;
use ABO\MainBundle\Entity\Category;
use ABO\MainBundle\Entity\Color;
use ABO\MainBundle\Entity\Image;
use ABO\MainBundle\Entity\Place;
use ABO\MainBundle\Entity\Size;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends Command {

    protected $em;
    private $save;

    public function __construct(EntityManager $entityManager) {

        $this->em = $entityManager;
        parent::__construct();
    }

    protected function configure() {

        $this
            ->setName('abo:install')
            ->setDescription('Install an array of entities in the database.')
            ->addArgument(
                'entity',
                InputArgument::REQUIRED,
                'Please select an entity to install. Available entities are : category, color, size and image.'
            )
            ->addOption(
                'save',
                null,
                InputOption::VALUE_OPTIONAL,
                'If set, entityManager::flush will be called.',
                false
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $entity = $input->getArgument('entity');
        $number = 0;
        $stat = 'success';
        $this->save = (bool) $input->getOption('save');
        switch ($entity) {
            
            case 'category': //success
                $catClass = new Categories();
                $output->writeln('installing categories in DB...');
                $number = $this->installCategories( $catClass->getCategories() );
                break;
            case 'color': // success
                $catClass = new Categories();
                $output->writeln('installing colors in DB...');
                $number = $this->installColors( $catClass->getColors() );
                break;
            case 'size': // success
                $catClass = new Categories();
                $output->writeln('installing sizes in DB...');
                $number = $this->installSizes( $catClass->getSizes() );
                break;
            case 'country': // success
                $placeClass = new Places();
                $output->writeln('installing country "TN" in DB...');
                $number = $this->installCountry( $placeClass->getCountry() );
                break;
            case 'image': // success
                $placeClass = new Places();
                $output->writeln('installing default images in DB...');
                $number = $this->installImages( $placeClass->getImages() );
                break;
            default:
                $stat = 'error';
                $output->writeln('undefined entity given.');
                break;
        }

        if( $stat === 'success' ){
            if($number === 0)
                $output->writeln($number . ' ' . $entity . ' entity installed.');
            else
                $output->writeln($number . ' ' . $entity . ' entity installed.');

            if ($this->save)
                $this->em->flush();
            else
                $output->writeln('data won\'t be saved to DB. To do so please use --save=true');
        }
        elseif ( $stat === 'error' )
            $output->writeln('Please select an entity to install. Available entities are : category, color, size and image.');
    }

    private function installCategories($categories) {

        $l1 = $l2 = $l3 = 0;
        foreach ($categories as $lvl1 => $lvl2Arr) {

            $cat1[$l1] = new Category();
            $cat1[$l1]->setName($lvl1);
            $this->em->persist($cat1[$l1]);
            $this->flush();

            foreach ($lvl2Arr as $lvl2 => $lvl3Arr) {

                $cat2[$l2] = new Category();
                $cat2[$l2]->setName($lvl2);
                $cat2[$l2]->setParent($cat1[$l1]);
                $this->em->persist($cat2[$l2]);
                $this->flush();

                foreach ($lvl3Arr as $lvl3=>$specsClass) {

                    $cat3[$l3] = new Category();
                    $cat3[$l3]->setName($lvl3);
                    $cat3[$l3]->setSpecsClass($specsClass);
                    $cat3[$l3]->setParent($cat2[$l2]);
                    $this->em->persist($cat3[$l3]);
                    $l3++;
                }
                $l2++;
            }
            $l1++;
        }
        return ( $l1 + $l2 + $l3 );
    }

    private function installSizes($sizes) {

        $i = 0;
        foreach ($sizes as $value) {

            foreach ($value['values'] as $val) {
                $size = new Size($value['age'], $value['clothe'], $value['sexe'], $value['type']);
                $size->setValue($val);
                $this->em->persist($size);
                $i++;
            }
        }
        return $i;
    }

    private function installImages( array $images) {

        $i = 0;
        foreach ($images as $image) {

            $img = new Image();
            $img->setEntity($image['entity']);
            $img->setFolder($image['folder']);
            $img->setType($image['type']);
            $img->setImage($image['image']);
            $this->em->persist($img);
            $i++;
        }
        return $i;
    }

    private function installCountry($country) {

        $s = $c = 0;
        $cntry = $this->em->getRepository('ABOMainBundle:Place')->findOneBy(array(
            'name'=>$country['name'], 'type'=>'country'
        ));
        if(!$cntry){
            $tn = new Place();
            $tn->setName($country['name']);
            $tn->setPhoneCode($country['code']);
            $tn->setRegexFormat($country['regex']);
            $tn->setType('country');
            $this->em->persist($tn);
            $this->flush();
        }
        foreach ($country['data'] as $state=>$cities) {

            $st[$s] = new Place();
            $st[$s]->setName($state);
            $st[$s]->setParent($tn);
            $st[$s]->setType('state');
            $this->em->persist($st[$s]);
            $this->flush();
            foreach ($cities as $city) {

                $ct[$c] = new Place();
                $ct[$c]->setName($city);
                $ct[$c]->setParent($st[$s]);
                $ct[$c]->setType('city');
                $this->em->persist($ct[$c]);
                $c++;
            }
            $s++;
        }
        return ($c + $s + 1);
    }

    private function installColors( array $colors ) {

        $i = 0;
        foreach ($colors as $color) {
            $clr = new Color();
            $clr->setCode($color);
            $this->em->persist($clr);
            $i++;
        }
        return $i;
    }

    private function flush(){

        if($this->save)
            $this->em->flush();
    }

}
