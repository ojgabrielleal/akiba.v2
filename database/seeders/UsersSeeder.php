<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $host = '108.181.92.77';
            $dbname = 'akiba-base';
            $user = 'administradorbg';
            $pass = 'akibamaster1013';

            $pdo = new \PDO("mysql:host=$host;dbname=$dbname",$user,$pass, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);

            echo "Connected to old akiba database.\n\n";
        }catch (\PDOException $e) {
            echo "Connection to old akiba database failed: " . $e->getMessage() . "\n";
        }

        try{
            $query = $pdo->query("SELECT * FROM usuarios");

            while ($row = $query->fetch()) {
                DB::table('users')->insert([
                    'slug' => Str::slug($row['apelido']),
                    'username' => $row['usuario'],
                    'password' => Hash::make($row['senha']),
                    'name' => $row['nome'],
                    'nickname' => $row['apelido'],
                    'city' => $row['cidade'],
                    'bibliography' => $row['biografia'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            echo "Users inserted into new akiba database.\n";
        }catch(\PDOException $e) {
            echo "Query failed: " . $e->getMessage() . "\n";
        }

    }
}
