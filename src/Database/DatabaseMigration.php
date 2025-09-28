<?php

namespace Neo\PicpayDesafioBackend\Database;

use Exception;
use Neo\PicpayDesafioBackend\Database\InterfaceMigrate;

class DatabaseMigration
{
    public function __construct(private Database $database, private bool $debug = true) {}

    private function noDebugStart(): void
    {
        if ($this->debug) return;

        ob_start();
    }

    private function noDebugEnd(): void
    {
        if ($this->debug) return;

        ob_end_clean();
    }

    public function migrate(): bool
    {
        $this->noDebugStart();

        try {
            $migrations = [];

            $migrationsTableExist = $this->database->query(<<<SQL
                SELECT COUNT(*) AS total FROM information_schema.tables
                WHERE table_schema = ? AND table_name = 'migrations'
            SQL, [ $this->database->getDatabaseName() ]);
            $migrationsTableExist = (int) $migrationsTableExist[0]['total'];

            if ($migrationsTableExist > 0) {
                $migrations = $this->database->query('SELECT migration_name FROM migrations');
                $migrations = array_column($migrations, 'migration_name');
            }

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

            $this->noDebugEnd();

            return true;
        } catch (Exception $e) {
            echo "Migration failed: " . $e->getMessage().PHP_EOL;

            $this->noDebugEnd();

            return false;
        }
    }

    public function rollback(): bool
    {
        $this->noDebugStart();

        try {
            $rows = $this->database->query('SELECT * FROM migrations ORDER BY created_at DESC LIMIT 1');
            $migration = $rows[0]['migration_name'];

            $list = scandir(__DIR__.'/Migrations');

            if ($list === false) {
                throw new Exception('Failed to read migrations directory');
            }

            if (empty($list)) {
                throw new Exception('No migration files found');
            }

            if (!in_array($migration, $list)) {
                throw new Exception('Last migration not found');
            }

            echo 'Migration rollback: '.$migration.PHP_EOL;

            require_once __DIR__.'/Migrations/'.$migration;

            $nameClass = pathinfo($migration, PATHINFO_FILENAME);
            $nameClass = substr($nameClass, strpos($nameClass, '__') + 2);

            $migrationClass = "Neo\\PicpayDesafioBackend\\Database\\Migrations\\{$nameClass}";

            if (!class_exists($migrationClass)) {
                throw new Exception("Migration class {$migrationClass} does not exist");
            }

            $migrationInstance = new $migrationClass();

            if (!($migrationInstance instanceof InterfaceMigrate)) {
                throw new Exception("Migration class {$migrationClass} does not implement InterfaceMigrate");
            }

            $migrationInstance->down($this->database);

            if (!str_starts_with($migration, '0000')) $this->database->query('DELETE FROM migrations WHERE migration_name = ?', [$migration]);

            $this->noDebugEnd();

            return true;
        }
        catch (Exception $e) {
            echo 'Rollback failed: '.$e->getMessage().PHP_EOL;

            $this->noDebugEnd();

            return false;
        }
    }
}
