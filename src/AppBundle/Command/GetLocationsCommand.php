<?php

namespace AppBundle\Command;

use AppBundle\Model\PlaceOfInterest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \Exception;

class GetLocationsCommand extends ContainerAwareCommand
{

    public function __construct()
    {
        parent::__construct($name = null);
    }

    protected function configure()
    {
        $this
            ->setName('app:get_locations')
            ->setDescription('Tries to find objects geographical locations.')
            ->setHelp('This command allows you to find locations of some places of interest...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            echo
                implode("\n",
                    array_map(
                        function (PlaceOfInterest $place)
                        {
                            return $place->toString();
                        },
                        $this->getContainer()->get('locationsService')->getPlacesOfInterest()
                    )
                );
        } catch (Exception $e) {
            echo 'Some error occured while trying to fetch locations data';
        }
    }
}