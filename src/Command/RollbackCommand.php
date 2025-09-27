<?php

namespace Neo\PicpayDesafioBackend\Command;

use Neo\PicpayDesafioBackend\Command\InterfaceCommand;
use Neo\PicpayDesafioBackend\Database\Database;
use Neo\PicpayDesafioBackend\Database\DatabaseMigration;
use Neo\PicpayDesafioBackend\Infra\ContainerDependency;

class RollbackCommand implements InterfaceCommand
{
    public static function execute(ContainerDependency $container, array $args): void
    {
        $database = $container->get(Database::class);
        $migration = new DatabaseMigration($database);

        if ($migration->rollback()) {
            echo "Database rollback completed successfully.\n";
        }
    }
}
