<?php

use Neo\PicpayDesafioBackend\Config\Config;
use Neo\PicpayDesafioBackend\Config\LoaderConfigEnv;
use Neo\PicpayDesafioBackend\Database\Database;
use Neo\PicpayDesafioBackend\Infra\ContainerDependency;
use Neo\PicpayDesafioBackend\Model\Model;

/**
 * Inicia as configurações do sistema.
 */

$loaderConfig = new LoaderConfigEnv(__DIR__.'/../.env');
$config = new Config($loaderConfig);

/**
 * Define a conexão com o banco de dados.
 */
$database = new Database(
    database: $config->get('database.name'),
    host:     $config->get('database.host'),
    port:     $config->get('database.port'),
    username: $config->get('database.username'),
    password: $config->get('database.password')
);
Model::setDatabase($database);

$container = new ContainerDependency([
    Config::class   => $config,
    Database::class => $database
]);
