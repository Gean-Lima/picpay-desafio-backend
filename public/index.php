<?php

declare(strict_types=1);

use Neo\PicpayDesafioBackend\Config\Config;
use Neo\PicpayDesafioBackend\Database\Database;
use Neo\PicpayDesafioBackend\Database\DatabaseDriver;
use Neo\PicpayDesafioBackend\Http\Routing\Routes;
use Neo\PicpayDesafioBackend\Model\Model;

require __DIR__.'/../vendor/autoload.php';

include __DIR__.'/../src/routes.php';

/**
 * Inicia as configurações do sistema.
 */
$config = Config::getInstance();

/**
 * Define a conexão com o banco de dados.
 */
$database = database();
Model::setDatabase($database);

/**
 * Encontra a rota atual e renderiza o conteúdo.
 * Se não encontrar, retorna 404.
 * Se for um arquivo público, retorna o conteúdo do arquivo.
 */
$routes = Routes::getInstance();

$requestUri = $_SERVER['REQUEST_URI'];

$publicFile = __DIR__.'/'.$requestUri;

if (!is_dir($publicFile) && file_exists($publicFile))
{
    $content = file_get_contents($publicFile);
    $mime = mime_content_type($publicFile);

    header('Content-Type: '.$mime);
    echo $content;

    die;
}

$routeName = Routes::currentRouteName();

/** @var Route|null $route */
$route = array_find($routes->getList(), fn($_, $key) => $key === $routeName);

if ($route) {
    $route->render();
    die;
}

http_response_code(404);
