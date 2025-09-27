<?php

namespace Neo\PicpayDesafioBackend\Config;

class Config
{
    private LoaderConfig $loader;
    private array $config = [];

    public function __construct(LoaderConfig $loader)
    {
        $this->loader = $loader;
        $this->config = $this->loader->load();
    }

    public function get(string $key): mixed
    {
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }

        throw new \InvalidArgumentException("Config key '{$key}' not found.");
    }
}

