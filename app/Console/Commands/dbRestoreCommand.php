<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class dbRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:db-restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restores the database from the latest SQL backup';

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

        $backupDir = storage_path("app/backups");
        $backupFiles = glob("{$backupDir}/*.sql");

        if (empty($backupFiles)) {
            $this->error("No backup file found in: {$backupDir}");
            return;
        }

        // Assume there's only one backup file (by nosso padrão atual)
        $backupFile = $backupFiles[0];

        $this->info("Restoring database from: {$backupFile}");

        $command = "mysql --user={$dbUser} --password={$dbPass} --host={$dbHost} --port={$dbPort} {$dbName} < {$backupFile}";

        $result = null;
        $output = null;
        exec($command, $output, $result);

        if ($result === 0) {
            $this->info("Database restored successfully!");
        } else {
            $this->error("Failed to restore database. Make sure 'mysql' is installed and accessible.");
        }
    }
}
