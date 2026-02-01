<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Dev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manager Laravel and Svelte development servers togheter';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Laravel development server');

        $laravel = new Process(['php', 'artisan', 'serve']);
        $laravel->setTimeout(null);
        $laravel->start();

        $this->info('Starting Vite development server');

        $vite = new Process(['npm', 'run', 'dev']);
        $vite->setTimeout(null);
        $vite->start();

        while ($laravel->isRunning() || $vite->isRunning()) {
            $laravelOutput = $laravel->getIncrementalOutput();
            if($laravelOutput){
                $this->line("[Laravel] " . trim($laravelOutput));
            }

            $viteOutput = $vite->getIncrementalOutput();
            if($viteOutput){
                $this->line("[Vite] " . trim($viteOutput));
            }

            usleep(100_000);
        }
    }

}
