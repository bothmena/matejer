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

class SitemapCommand extends Command {

    protected $em;

    public function __construct(EntityManager $entityManager) {

        $this->em = $entityManager;
        parent::__construct();
    }

    protected function configure() {

        $this
            ->setName('abo:sitemap')
            ->setDescription('Install an array of tags in the database.')
            ->addArgument(
                'entity',
                InputArgument::REQUIRED,
                'Please select an entity to sitemap. Available entities are : product, shop and offer.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $entity = $input->getArgument('entity');
        switch ($entity) {
            case 'product':
                $this->em->getRepository('ABOMainBundle:CategoryProduct')->find(1);
                break;
            case 'shop':
                $this->em->getRepository('ABOMainBundle:CategoryProduct')->find(1);
                break;
            case 'offer':
                $this->em->getRepository('ABOMainBundle:CategoryProduct')->find(1);
                break;
            default:
                $output->writeln($entity.' is not a valid entity. valid entities are: product, shop and offer.');
                break;
        }
    }
}
