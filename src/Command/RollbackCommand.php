<?php

namespace Neo\PicpayDesafioBackend\Command;

use Neo\PicpayDesafioBackend\Command\InterfaceCommand;
use Neo\PicpayDesafioBackend\Config\Config;
use Neo\PicpayDesafioBackend\Database\DatabaseMigration;

class RollbackCommand implements InterfaceCommand
{
    public static function execute(array $args): void
    {
        $database = database();
        $migration = new DatabaseMigration($database, Config::getInstance());

        if ($migration->rollback()) {
            echo "Database rollback completed successfully.\n";
        }
    }
}
