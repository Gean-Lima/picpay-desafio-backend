<?php

namespace Neo\PicpayDesafioBackend\Test;

use Neo\PicpayDesafioBackend\Database\Database;
use Neo\PicpayDesafioBackend\Database\DatabaseDriver;
use Neo\PicpayDesafioBackend\Config\Config;
use Neo\PicpayDesafioBackend\Model\Model;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

class TestCase extends FrameworkTestCase
{
    protected static Database $database;


    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $config = Config::getInstance();

        $database = new Database(
            driver: DatabaseDriver::SQLITE,
            database: $config->get('database.test.path')
        );
        Model::setDatabase($database);

        self::$database = $database;
    }
}
