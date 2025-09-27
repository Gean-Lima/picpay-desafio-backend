<?php

namespace Neo\PicpayDesafioBackend\Database;

use Exception;
use PDO;

class Database
{
    private PDO $connection;

    private string $database {
        set(string $value) {
            if (empty($value)) {
                throw new \InvalidArgumentException('Database name cannot be empty.');
            }
            $this->database = $value;
        }
    }

    public function __construct(
        string $database,
        private ?string $host = null,
        private ?string $port = null,
        private ?string $username = null,
        private ?string $password = null,
    ) {
        $this->database = $database;
        $this->connection = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->database}",$this->username, $this->password);
    }

    public function getDatabaseName(): string
    {
        return $this->database;
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
