<?php

namespace Neo\PicpayDesafioBackend\Database\Migrations;

use Neo\PicpayDesafioBackend\Database\Database;
use Neo\PicpayDesafioBackend\Database\DatabaseDriver;
use Neo\PicpayDesafioBackend\Database\Migrations\InterfaceMigrate;

class UserMigration implements InterfaceMigrate
{
    public function up(Database $db): void
    {
        $db->query(<<<SQL
            CREATE TABLE IF NOT EXISTS users (
                id UNSIGNED BIGINT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                cpf_cnpj VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                delete_at TIMESTAMP NULL DEFAULT NULL
            )
        SQL);
    }

    public function down(Database $db): void
    {
        $db->query(<<<SQL
            DROP TABLE IF EXISTS users
        SQL);
    }
}
