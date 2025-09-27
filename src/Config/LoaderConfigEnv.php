<?php

namespace Neo\PicpayDesafioBackend\Config;

use Neo\PicpayDesafioBackend\Config\LoaderConfig;

class LoaderConfigEnv extends LoaderConfig
{
    public function __construct(private string $filePath)
    {}

    public function load(): array
    {
        $configFile = $this->filePath;
        $config = [];

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

            $config[$name] = $value;
        }

        return $config;
    }
}
