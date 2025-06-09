<?php

namespace Neo\PicpayDesafioBackend\Test;

use Neo\PicpayDesafioBackend\Database\Database;
use Neo\PicpayDesafioBackend\Model\Model;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

class TestCase extends FrameworkTestCase
{
    public static Database $database;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $database = database(testMode: true);
        Model::setDatabase($database);

        self::$database = $database;
    }
}
