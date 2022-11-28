<?php

namespace App\Command;

use App\Entity\Personnage;
use App\Repository\PersonnageRepository;
use App\services\HpApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(
    name: 'app:get-hp-hero',
    description: 'Add a short description for your command',
)]
class GetHpHeroCommand extends Command
{
    public function __construct(
        private HpApiService         $hpApiService,
//        private EntityManagerInterface $entityManger,
        private PersonnageRepository $personnageRepository,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $personnages = $this->hpApiService->getAllCharacters();

        $toto = 0;
        foreach ($personnages as $personnage) {
//            $output->writeln($personnage['name']);
//            if (!($this->personnageRepository->findPersoByName($personnage['name']))) {
            if (!($this->personnageRepository->findOneBy(['name' => $personnage['name']]))) {
                $character = new Personnage();
                $character->setGender($personnage['gender']);
                $character->setName($personnage['name']);
                $character->setHouse($personnage['house']);
                $character->setImage($personnage['image']);
                $character->setDateOfBirth(new \DateTime($personnage['dateOfBirth']));

//            $this->entityManger->persist($character);
//            $this->entityManger->flush();

                $this->personnageRepository->save($character, true);
                $toto += 1;

            }
        }
        $output->writeln($toto);
        return Command::SUCCESS;
    }
}
