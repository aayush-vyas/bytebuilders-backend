<?php

namespace App\Command;

use App\Entity\Allergies;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InsertAllergyCommand extends Command
{
    protected static $defaultName = 'insert:allergy';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Insert predefined allergy data into the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $allergyTitles = [
            'Peanuts',
            'Dairy',
            'Gluten',
            'Shellfish',
            'Soy'
        ];

        foreach ($allergyTitles as $title) {
            $allergy = new Allergies();
            $allergy->setTitle($title);

            $this->entityManager->persist($allergy);
        }

        $this->entityManager->flush();

        $io->success('Allergy data has been inserted into the database.');

        return Command::SUCCESS;
    }
}
