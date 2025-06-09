<?php

namespace Neo\PicpayDesafioBackend\Database;

use Exception;
use Neo\PicpayDesafioBackend\Database\Migrations\InterfaceMigrate;

class DatabaseMigration
{
    public function __construct(private Database $database) {}

    public function migrate(): bool
    {
        try {
            $migrations = $this->database->query('SELECT migration_name FROM migrations');
            $migrations = array_column($migrations, 'migration_name');

            $list = scandir(__DIR__ . '/Migrations');

            if ($list === false) {
                throw new Exception('Failed to read migrations directory');
            }

            if (empty($list)) {
                throw new Exception('No migration files found');
            }

            $list = array_filter($list, function ($file) use ($migrations) {
                if ($file === '.' || $file === '..') return false;

                return !in_array($file, $migrations) && str_ends_with($file, 'Migration.php');
            });

            if (empty($list)) {
                echo "No new migrations to run.\n";
                return false;
            }

            sort($list);

            foreach ($list as $file) {
                echo "Running migration: {$file}\n";

                require_once __DIR__ . '/Migrations/' . $file;

                $nameClass = pathinfo($file, PATHINFO_FILENAME);
                $nameClass = substr($nameClass, strpos($nameClass, '__') + 2);

                $migrationClass = "Neo\\PicpayDesafioBackend\\Database\\Migrations\\{$nameClass}";

                if (!class_exists($migrationClass)) {
                    throw new Exception("Migration class {$migrationClass} does not exist");
                }

                $migration = new $migrationClass();

                if (!($migration instanceof InterfaceMigrate)) {
                    throw new Exception("Migration class {$migrationClass} does not implement InterfaceMigrate");
                }

                $migration->up($this->database);

                $this->database->query('INSERT INTO migrations (migration_name) VALUES (?)', [$file]);
            }

            return true;
        } catch (Exception $e) {
            echo "Migration failed: " . $e->getMessage();
            return false;
        }
    }
}
