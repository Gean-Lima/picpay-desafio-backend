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
