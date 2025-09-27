<?php

declare(strict_types=1);

use Neo\PicpayDesafioBackend\Http\Routing\Routes;

require_once __DIR__.'/../vendor/autoload.php';

try {
    require_once __DIR__.'/../src/bootstrap.php';
    require_once __DIR__.'/../src/routes.php';

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
}
catch (Throwable $e) {
    http_response_code(500);
    echo 'Erro interno no servidor: '.$e->getMessage();
    die;
}

