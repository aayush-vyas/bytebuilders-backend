<?php

namespace App\Command;

use App\Entity\Cuisine;
use App\Entity\Cuisines;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InsertCuisineCommand extends Command
{
    protected static $defaultName = 'insert:cuisine';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Insert predefined cuisine data into the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $cuisineTitles = [
            'American',
            'Chinese',
            'Indian',
            'Mexican',
            'Thai',
            'Italian'
        ];

        foreach ($cuisineTitles as $title) {
            $cuisine = new Cuisine();
            $cuisine->setTitle($title);

            $this->entityManager->persist($cuisine);
        }

        $this->entityManager->flush();

        $io->success('Cuisine data has been inserted into the database.');

        return Command::SUCCESS;
    }
}
