<?php

require_once __DIR__.'/../../vendor/autoload.php';

$commands = [
    'migrate' => Neo\PicpayDesafioBackend\Command\MigrateCommand::class
];

$command = $argv[1] ?? null;

if (!$command) {
    echo "Nenhum comando informado.".PHP_EOL;
    die;
}

if (!key_exists($command, $commands)) {
    echo "Comando '$command' não encontrado.".PHP_EOL;
    die;
}

$commandClass = $commands[$command];

call_user_func([$commandClass, 'execute'], array_slice($argv, 2));
