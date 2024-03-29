<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'shop:install-command';

    protected $description = 'Installation';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->call('storage:link');
        $this->call('migrate');
        
        return self::SUCCESS;
    }
}
