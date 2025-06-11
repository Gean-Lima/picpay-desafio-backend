<?php

namespace Neo\PicpayDesafioBackend\Database\Migrations;

use Neo\PicpayDesafioBackend\Database\Database;
use Neo\PicpayDesafioBackend\Database\InterfaceMigrate;

class MigrationsMigration implements InterfaceMigrate
{
    public function up(Database $db): void
    {
        $db->query(<<<SQL
            CREATE TABLE IF NOT EXISTS migrations (
                id INTEGER AUTO_INCREMENT PRIMARY KEY,
                migration_name VARCHAR(255) NOT NULL UNIQUE,
                created_at TIMESTAMP(3) DEFAULT CURRENT_TIMESTAMP(3)
            );
        SQL);
    }

    public function down(Database $db): void
    {
        $db->query(<<<SQL
            DROP TABLE IF EXISTS migrations;
        SQL);
    }
}
