<?php

# src/App/JoboardBundle/Command/JoboardCleanupCommand.php

namespace App\JoboardBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class JoboardCleanupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:joboard:cleanup')
            ->setDescription('Очистка базы данных')
            ->addArgument('days', InputArgument::OPTIONAL, 'The email', 90)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $days = $input->getArgument('days');

        $em = $this->getContainer()->get('doctrine')->getManager();
        $nb = $em->getRepository('AppJoboardBundle:Job')->cleanup($days);

        $output->writeln(sprintf('Удалено %d вакансий', $nb));
    }
}