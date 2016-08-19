<?php

/**
 * Created by PhpStorm.
 * User: aymen
 * Date: 29/04/16
 * Time: 19:56
 */

namespace ABO\AdminBundle\Command;

use ABO\MainBundle\Entity\Size;
use ABO\MainBundle\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TagCommand extends Command {

    protected $em;
    private $save;

    public function __construct(EntityManager $entityManager) {

        $this->em = $entityManager;
        parent::__construct();
    }

    protected function configure() {

        $this
            ->setName('abo:tag')
            ->setDescription('Install an array of tags in the database.')
            ->addArgument(
                'entity',
                InputArgument::REQUIRED,
                'Please select an entity to tag. Available entities are : category, color, size and static.'
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
        $this->save = (bool) $input->getOption('save');
        $number = 0;
        $status = 'success';
        switch ($entity){
            case 'category':
                $number = $this->tagCategory();
                $output->writeln('Tagging categories...');
                break;
            case 'color':
                $number = $this->tagColors();
                $output->writeln('Tagging colors...');
                break;
            case 'size':
                $number = $this->tagSizes();
                $output->writeln('Tagging sizes...');
                break;
            case 'place':
                $number = $this->tagPlace();
                $output->writeln('Tagging places...');
                break;
            case 'static':
                $number = $this->tagStatic();
                $output->writeln('Tagging statics...');
                break;
            default:
                $status = 'error';
                break;
        }

        if($status === 'success'){
            if($number === 0)
                $output->writeln('this entity is empty, please install some items in database first using abo:install command.');
            else
                $output->writeln($number . ' ' . $entity . ' tagged.');

            if ( $this->save )
                $this->em->flush();
            else
                $output->writeln('data won\'t be saved to DB. To do so please use --save=true.');
        }else
            $output->writeln('Please select an entity to tag. Available entities are : category, color, size and static.');
    }

    private function tagCategory() {

        $i = 0;
        $categories = $this->em->getRepository('ABOMainBundle:Category')->findAll();
        foreach ($categories as $entity) {

            $tag = new Tag();
            $tag->setName($entity->getSlug());
            $tag->setType('category');
            $this->em->persist($tag);
            $i++;
        }
        return $i;
    }

    private function tagPlace() {

        $i = 0;
        $places = $this->em->getRepository('ABOMainBundle:Place')->findAll();
        foreach ($places as $place) {

            $tag = new Tag();
            $tag->setName($place->getSlug());
            $tag->setType('place');
            $this->em->persist($tag);
            $i++;
        }
        return $i;
    }

    private function tagStatic() {

        $i = 0;
        $staticTags = array(
            'rate-0' => 'rate',
            'rate-1' => 'rate',
            'rate-2' => 'rate',
            'rate-3' => 'rate',
            'rate-4' => 'rate',
            'rate-5' => 'rate',
            'has-discount' => 'promotion',
            'has-promotion' => 'promotion',
            'has-payment' => 'promotion',
            'discount-10' => 'promotion',
            'discount-20' => 'promotion',
            'discount-30' => 'promotion',
            'discount-40' => 'promotion',
            'discount-50' => 'promotion',
            'discount-60' => 'promotion',
            'discount-70' => 'promotion',
            'discount-80' => 'promotion',
            'discount-90' => 'promotion',
        );
        foreach ($staticTags as $name=>$type) {

            $tag = new Tag();
            $tag->setName($name);
            $tag->setType($type);
            $this->em->persist($tag);
            $i++;
        }
        return $i;
    }

    private function tagColors() {

        $i = 0;
        $colors = $this->em->getRepository('ABOMainBundle:Color')->findAll();
        foreach ($colors as $color) {

            $tag = new Tag();
            $tag->setName($color->getCode());
            $tag->setType('color');
            $this->em->persist($tag);
            $i++;
        }
        return $i;
    }

    private function tagSizes() {

        $i = 0;
        $sizes = $this->em->getRepository('ABOMainBundle:Size')->findAll();
        foreach ($sizes as $size) {

            $tag = new Tag();
            /** @var Size $size */
            $tag->setName($size->getSlug());
            $tag->setType('size');
            $this->em->persist($tag);
            $i++;
        }
        return $i;
    }
}
