<?php

namespace Neo\PicpayDesafioBackend\Database;

use Exception;
use Neo\PicpayDesafioBackend\Database\Migrations\InterfaceMigrate;
use PDO;

class Database
{
    private PDO $connection;

    public function __construct(
        private DatabaseDriver $driver,
        private string $database,
        private ?string $host = null,
        private ?string $port = null,
        private ?string $username = null,
        private ?string $password = null,
    ) {
        $this->connection = match ($this->driver) {
            DatabaseDriver::MYSQL => new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->database}",$this->username, $this->password),
            DatabaseDriver::SQLITE => new PDO('sqlite:'.$this->database)
        };
    }

    public function getDriver(): DatabaseDriver
    {
        return $this->driver;
    }

    public function migrate(): bool
    {
        try {
            $list = scandir(__DIR__.'/Migrations');

            if ($list === false) {
                throw new Exception('Failed to read migrations directory');
            }

            if (empty($list)) {
                throw new Exception('No migration files found');
            }

            sort($list);

            foreach($list as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                if (!str_ends_with($file, 'Migration.php')) {
                    continue;
                }

                require_once __DIR__.'/Migrations/'.$file;

                $nameClass = pathinfo($file, PATHINFO_FILENAME);
                $nameClass = substr($nameClass, strpos($nameClass, '__') + 2);

                $migrationClass = "Neo\\PicpayDesafioBackend\\Database\\Migrations\\{$nameClass}";

                if (!class_exists($migrationClass)) {
                    throw new Exception("Migration class {$migrationClass} does not exist");
                }

                $migration = new $migrationClass();

                if ($migration instanceof InterfaceMigrate) {
                    $migration->up($this);
                } else {
                    throw new Exception("Migration class {$migrationClass} does not implement InterfaceMigrate");
                }
            }

            return true;
        }
        catch (Exception $e) {
            // Log the exception or handle it as needed
            echo "Migration failed: " . $e->getMessage();
            return false;
        }
    }

    public function query(string $sql, array $params = []): array
    {
        try {
            $statement = $this->connection->prepare($sql);

            if ($statement->execute($params) === false) {
                throw new Exception("Query execution failed: " . implode(", ", $statement->errorInfo()));
            }

            return $statement->fetchAll();
        }
        catch (Exception $e) {
            throw new Exception("Query failed: " . $e->getMessage());
        }
    }
}

enum DatabaseDriver: string
{
    case MYSQL = 'mysql';
    case SQLITE = 'sqlite';
}
