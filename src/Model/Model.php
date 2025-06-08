<?php

namespace Neo\PicpayDesafioBackend\Model;

use Neo\PicpayDesafioBackend\Database\Database;

abstract class Model
{
    abstract protected string $tableName {
        get;
        set(string $value) {
            if (empty($value)) {
                throw new \InvalidArgumentException('Table name cannot be empty.');
            }
            $this->tableName = $value;
        }
    }

    abstract protected array $fields {
        get;
        set(array $value) {
            if (empty($value)) {
                throw new \InvalidArgumentException('Fields cannot be empty.');
            }
            $this->fields = $value;
        }
    }

    private static ?Database $database = null;

    static function setDatabase(Database $database): void
    {
        self::$database = $database;
    }

    static function getDatabase(): ?Database
    {
        if (self::$database === null) {
            throw new \RuntimeException('Database not set. Please set the database before using the model.');
        }
        return self::$database;
    }
}
