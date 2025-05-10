<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class dbRestore extends Command
{
    protected $signature = 'db-restore';
    protected $description = 'This command will restore the database from a backup file';

    public function handle()
    {
        $host = env('DB_HOST');
        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');

        // Prompt the user for the backup file path
        $backupFolder = storage_path('app/backup');
        $files = glob($backupFolder . '/*.sql');

        if (empty($files)) {
            $this->error('No backup files found in the backup folder.');
            return;
        }

        // Get the most recent backup file
        $backupFile = array_reduce($files, function ($latest, $file) {
            return filemtime($file) > filemtime($latest) ? $file : $latest;
        }, $files[0]);

        $this->info('Using backup file: ' . $backupFile);

        $command = "mysql --host={$host} --user={$user} --password={$password} {$database} < {$backupFile}";
        $output = null;
        $returnVar = null;
        exec($command, $output, $returnVar);

        // Check if the command was successful
        if ($returnVar === 0) {
            $this->info('Database restored successfully from ' . $backupFile);
        } else {
            $this->error('Failed to restore database. Error: ' . implode("\n", $output));
        }
    }
}
