<?php

namespace Neo\PicpayDesafioBackend\Test;

use Neo\PicpayDesafioBackend\Database\Database;
use Neo\PicpayDesafioBackend\Database\DatabaseMigration;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

require_once __DIR__ . '/bootstrap_test.php';

class TestCase extends FrameworkTestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $migration = new DatabaseMigration(container()->get(Database::class), false);
        $migration->migrate();
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        $migration = new DatabaseMigration(container()->get(Database::class), false);
        $migration->rollback();
    }
}
