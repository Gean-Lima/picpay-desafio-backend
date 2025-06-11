<?php

namespace Neo\PicpayDesafioBackend\Database;

use Neo\PicpayDesafioBackend\Database\Database;

interface InterfaceMigrate
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Database $database): void;

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(Database $database): void;
}
