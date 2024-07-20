<?php

namespace App\Command;

use App\Entity\Diet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InsertDietCommand extends Command
{
    protected static $defaultName = 'insert:diet';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Insert predefined diet data into the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $dietTitles = [
            'Gluten Free',
            'Lacto-Vegetarian',
            'Ketogenic',
            'Vegetarian',
            'Vegan'
        ];

        foreach ($dietTitles as $title) {
            $diet = new Diet();
            $diet->setTitle($title);

            $this->entityManager->persist($diet);
        }

        $this->entityManager->flush();

        $io->success('Diet data has been inserted into the database.');

        return Command::SUCCESS;
    }
}
