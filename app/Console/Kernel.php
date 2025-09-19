<?php
// app/Console/Kernel.php

namespace App\Console;

use Nexacore\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(): void
    {
        // Run every minute
        $this->command('email:send')->everyMinute();
        
        // Run daily at midnight
        $this->command('db:backup')->daily();
        
        // Run every Sunday at 2:00 AM
        $this->command('reports:generate')->weekly()->sundays()->at('02:00');
        
        // Run a callback
        $this->call(function () {
            // Cleanup tasks
            \App\Models\TempFile::where('created_at', '<', now()->subDay())->delete();
        })->daily();
        
        // Run with specific timezone
        $this->command('notifications:send')->dailyAt('09:00')->timezone('America/New_York');
    }
    
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        // Load application commands from config
        $commands = $this->app->get('config')['console']['commands'] ?? [];
        
        foreach ($commands as $command) {
            if (class_exists($command)) {
                $this->console->add($this->app->getContainer()->get($command));
            }
        }
    }
}