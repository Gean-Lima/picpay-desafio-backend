<?php

namespace Neo\PicpayDesafioBackend\Config;

class Config
{
    private static ?Config $instance = null;

    private array $config = [];

    private function __construct()
    {
        $this->loadConfig();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
            return self::$instance;
        }

        return self::$instance;
    }

    public function loadConfig(): void
    {
        $configFile = __DIR__.'/../../.env';

        if (!file_exists($configFile)) {
            throw new \RuntimeException('Config file not found: '.$configFile);
        }

        $lines = file($configFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($lines === false) {
            throw new \RuntimeException('Failed to read config file: '.$configFile);
        }

        foreach ($lines as $line) {
            if (str_starts_with($line, '#')) {
                continue; // Pula os comentários
            }

            $parts = explode('=', $line, 2);

            $name = strtolower(str_replace('_', '.', trim($parts[0])));
            $value = trim($parts[1]);

            $this->config[$name] = $value;
        }
    }

    public function get(string $key): mixed
    {
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }

        throw new \InvalidArgumentException("Config key '{$key}' not found.");
    }
}
