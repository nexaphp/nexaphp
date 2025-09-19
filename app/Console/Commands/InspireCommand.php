<?php
// app/Console/Commands/InspireCommand.php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InspireCommand extends Command
{
    protected static $defaultName = 'inspire';
    protected static $defaultDescription = 'Display an inspiring quote';

    protected function configure(): void
    {
        $this->setDescription('Display an inspiring quote');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $quotes = [
            'When there is no desire, all things are at peace. - Laozi',
            'Simplicity is the ultimate sophistication. - Leonardo da Vinci',
            'Simplicity is the essence of happiness. - Cedric Bledsoe',
            'Smile, breathe, and go slowly. - Thich Nhat Hanh',
            'Simplicity is an acquired taste. - Katharine Gerould',
        ];
        
        $quote = $quotes[array_rand($quotes)];
        
        $output->writeln('');
        $output->writeln("  <comment>{$quote}</comment>");
        $output->writeln('');
        
        return Command::SUCCESS;
    }
}