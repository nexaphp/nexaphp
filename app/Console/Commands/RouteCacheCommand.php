<?php
// app/Console/Commands/RouteCacheCommand.php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Nexacore\Foundation\Application;

class RouteCacheCommand extends Command
{
    protected static $defaultName = 'route:cache';
    
    protected $app;
    
    public function __construct(Application $app)
    {
        parent::__construct();
        $this->app = $app;
    }
    
    protected function configure(): void
    {
        $this->setDescription('Create a route cache file for faster route registration')
             ->setHelp('This command creates a route cache file for faster application performance.');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $routeService = $this->app->getContainer()->get(\Nexacore\Providers\RouteServiceProvider::class);
        $routeService->cacheRoutes();
        
        $output->writeln('Routes cached successfully!');
        return Command::SUCCESS;
    }
}