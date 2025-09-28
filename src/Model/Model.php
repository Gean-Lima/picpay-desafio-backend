<?php

namespace Neo\PicpayDesafioBackend\Model;

use App\Entities\Entity;
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

    abstract protected string $entityClass {
        get;
        set(string $value) {
            if (!is_subclass_of($value, Entity::class)) {
                throw new \InvalidArgumentException('Entity class must be a subclass of Entity.');
            }

            if (empty($value)) {
                throw new \InvalidArgumentException('Entity class cannot be empty.');
            }

            $this->entityClass = $value;
        }
    }

    // Singleton Database instance
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
