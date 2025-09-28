<?php

namespace Neo\PicpayDesafioBackend\Config;

use Neo\PicpayDesafioBackend\Config\LoaderConfig;

class LoaderConfigMap extends LoaderConfig
{
    public function __construct(private array $map)
    {}

    public function load(): array
    {
        $config = [];

        foreach ($this->map as $key => $value) {
            $name = strtolower(str_replace('_', '.', trim($key)));
            $config[$name] = trim($value);
        }

        return $config;
    }
}
