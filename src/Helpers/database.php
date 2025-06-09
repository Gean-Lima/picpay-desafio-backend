<?php

use Neo\PicpayDesafioBackend\Config\Config;
use Neo\PicpayDesafioBackend\Database\Database;
use Neo\PicpayDesafioBackend\Database\DatabaseDriver;

function database(bool $testMode = false): Database
{
    $config = Config::getInstance();

    $database = match ($testMode) {
        true => new Database(
            driver: DatabaseDriver::SQLITE,
            database: $config->get('database.test.path')
        ),
        false => new Database(
            driver: DatabaseDriver::MYSQL,
            database: $config->get('database.name'),
            host: $config->get('database.host'),
            port: $config->get('database.port'),
            username: $config->get('database.username'),
            password: $config->get('database.password'),
        )
    };

    return $database;
}
