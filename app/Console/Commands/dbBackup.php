<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class dbBackup extends Command
{

    protected $signature = 'db-backup';
    protected $description = 'This command will create a backup of the database';

    public function handle()
    {
        $host = env('DB_HOST');
        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');

        $backupFile = storage_path('app/backup/' . date('Y-m-d_H-i-s') . '_backup.sql');
        $command = "mysqldump --host={$host} --user={$user} --password={$password} {$database} > {$backupFile}";
        $output = null;
        $returnVar = null;
        exec($command, $output, $returnVar);

        // Verify if the directory exists
        if (!file_exists(storage_path('app/backup'))) {
            mkdir(storage_path('app/backup'), 0755, true);
        }

        // Delete the existing backup file if it exists
        if (file_exists($backupFile)) {
            unlink($backupFile);
        }

        // Check if the command was successful
        if ($returnVar === 0) {
            $this->info('Database backup created successfully at ' . $backupFile);
        } else {
            $this->error('Failed to create database backup. Error: ' . implode("\n", $output));
        }
    }
}
