<?php

namespace Neo\PicpayDesafioBackend\Command;

use Neo\PicpayDesafioBackend\Database\DatabaseMigration;

class MigrateCommand implements InterfaceCommand
{
    public static function execute(array $args): void
    {
        $database = database();
        $migration = new DatabaseMigration($database);

        if ($migration->migrate()) {
            echo "Database migration completed successfully.\n";
        }
    }
}
