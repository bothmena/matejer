<?php

/**
 * Created by PhpStorm.
 * User: aymen
 * Date: 29/04/16
 * Time: 19:56
 */

namespace ABO\AdminBundle\Command;

use ABO\MainBundle\Entity\Image;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImageRemoveCommand extends Command {

    protected $em;

    public function __construct(EntityManager $entityManager) {

        $this->em = $entityManager;
        parent::__construct();
    }

    protected function configure() {

        $this
            ->setName('abo:image:remove')
            ->setDescription('Remove images that have been uploaded to gcs.')
            ->addArgument(
                'id',
                InputArgument::REQUIRED,
                'Please provide the id of the image to be deleted.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $id = $input->getArgument('id');
        $image = $this->em->getRepository('ABOMainBundle:Image')->find($id);
        /* @var $image Image */
        if($image){
            
            $image->setGcs(true);
            $image->setDate(new \DateTime);
            $this->em->flush();
            $output->writeln( $image->getSource() );
        }
        else
            $output->writeln( 'Error: image not found, where id = ' . $id );
    }
}
