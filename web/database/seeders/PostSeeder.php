<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
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

            $pdo = new \PDO("mysql:host=$host;dbname=$dbname", $user, $pass, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);

            echo "Connected to old akiba database.\n\n";
        } catch (\PDOException $e) {
            echo "Connection to old akiba database failed: " . $e->getMessage() . "\n";
        }

        try {
            $query = $pdo->query("SELECT * FROM postagens");

            while ($row = $query->fetch()) {

                switch ($row['idautor']) {
                    case 15:
                        $usuario_id = 1;
                        break;
                    case 16:
                        $usuario_id = 2;
                        break;
                    case 17:
                        $usuario_id = 3;
                        break;
                    case 18:
                        $usuario_id = 4;
                        break;
                    case 21:
                        $usuario_id = 5;
                        break;
                    case 22:
                        $usuario_id = 6;
                        break;
                    case 23:
                        $usuario_id = 7;
                        break;
                    case 24:
                        $usuario_id = 8;
                        break;
                }


                DB::table('posts')->insert([
                    'user_id' => $usuario_id,
                    'slug' => Str::slug($row['titulo']),
                    'image' => "#",
                    'title' => $row['titulo'],
                    'content' => $row['texto'],
                    'cover' => "#",
                    'status' => "published",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            echo "Posts inserted into new akiba database.\n";
        } catch (\PDOException $e) {
            echo "Query failed: " . $e->getMessage() . "\n";
        }
    }
}
