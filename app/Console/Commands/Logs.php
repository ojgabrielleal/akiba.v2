<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Logs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show laravel.log in real time on terminal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $logFile = storage_path('logs/laravel.log');

        if (!file_exists($logFile)) {
            $this->error("laravel.logs is not found: $logFile");
            return;
        }

        $this->info("Show logs from laravel.log in real time. Press CTRL+C to exit.\n");
        $handle = fopen($logFile, 'r');

        fseek($handle, 0, SEEK_END);

        while (true) {
            $line = fgets($handle);
            if ($line !== false) {
                $this->line($line);
            } else {
                usleep(100_000); 
            }
        }

        fclose($handle);
    }
}
