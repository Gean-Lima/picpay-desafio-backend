<?php

namespace Neo\PicpayDesafioBackend\Infra;

class ContainerDependency
{
    private array $services = [];

    public function __construct(array $services)
    {
        foreach ($services as $className => $service) {
            if (!class_exists($className) || !is_object($service)) {
                throw new \InvalidArgumentException("Service for {$className} must be an object.");
            }

            $this->services[$className] = $service;
        }
    }

    public function get(string $className): ?object
    {
        return $this->services[$className] ?? null;
    }
}
