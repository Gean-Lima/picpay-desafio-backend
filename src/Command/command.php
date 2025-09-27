<?php

require_once __DIR__ . '/../../vendor/autoload.php';

try {
    require_once __DIR__ . '/../bootstrap.php';

    $commands = [
        'migrate' => Neo\PicpayDesafioBackend\Command\MigrateCommand::class,
        'migrate:rollback' => Neo\PicpayDesafioBackend\Command\RollbackCommand::class
    ];

    $command = $argv[1] ?? null;

    if (!$command) {
        echo "Nenhum comando informado." . PHP_EOL;
        die;
    }

    if (!key_exists($command, $commands)) {
        echo "Comando '$command' não encontrado." . PHP_EOL;
        die;
    }

    $commandClass = $commands[$command];

    call_user_func([$commandClass, 'execute'], $container, array_slice($argv, 2));
}
catch (Exception $e) {
    echo "Erro ao executar comando: " . $e->getMessage() . PHP_EOL;
    die;
}
