<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
        name: 'app:calcul-number',
    description: 'Add a short description for your command',
)]
class CalculNumberCommand extends Command
{
    protected function configure(): void
    {
        $this
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')

//            ->addArgument('arg1', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('num1', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('num2', InputArgument::REQUIRED, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
//        $output->writeln("Bonjour...");
//        $arg1 = $input->getArgument('arg1');
//        $output->writeln($arg1);

        $num1 = $input->getArgument('num1');
        $num2 = $input->getArgument('num2');

        $res = $num1 + $num2;

        $output->writeln($res);

        return Command::SUCCESS;

//        $io = new SymfonyStyle($input, $output);
//        $arg1 = $input->getArgument('arg1');
//
//        if ($arg1) {
//            $io->note(sprintf('You passed an argument: %s', $arg1));
//        }
//
//        if ($input->getOption('option1')) {
//            // ...
//        }
//
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
//
//        return Command::SUCCESS;
    }
}
