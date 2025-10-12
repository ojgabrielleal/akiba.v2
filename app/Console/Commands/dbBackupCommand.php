<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class DbBackupCommand  extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:db-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a SQL dump backup of the database using environment credentials';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dbHost = env('DB_HOST');
        $dbPort = env('DB_PORT');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbName = env('DB_DATABASE');

        $timestamp = Carbon::now()->format('Ymd_His');
        $filename = "backup_{$dbName}_{$timestamp}.sql";
        $backupDir = storage_path("app/backups");
        $path = "{$backupDir}/{$filename}";

        // Ensure the backup directory exists
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        // Delete previous .sql backups in the folder
        $existingBackups = glob("{$backupDir}/*.sql");
        foreach ($existingBackups as $file) {
            unlink($file);
        }

        $command = "mysqldump --user={$dbUser} --password={$dbPass} --host={$dbHost} --port={$dbPort} {$dbName} > {$path}";

        $this->info("Starting database backup...");

        $result = null;
        $output = null;
        exec($command, $output, $result);

        if ($result === 0) {
            $this->info("Database backup completed successfully!");
            $this->line("Saved to: {$path}");
        } else {
            $this->error("Database backup failed. Make sure 'mysqldump' is installed and accessible from the shell.");
        }
    }
}