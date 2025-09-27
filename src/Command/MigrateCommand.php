<?php

namespace Neo\PicpayDesafioBackend\Command;

use Neo\PicpayDesafioBackend\Database\Database;
use Neo\PicpayDesafioBackend\Database\DatabaseMigration;
use Neo\PicpayDesafioBackend\Infra\ContainerDependency;

class MigrateCommand implements InterfaceCommand
{
    public static function execute(ContainerDependency $container, array $args): void
    {
        $database = $container->get(Database::class);
        $migration = new DatabaseMigration($database);

        if ($migration->migrate()) {
            echo "Database migration completed successfully.\n";
        }
    }
}
