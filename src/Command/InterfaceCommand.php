<?php

namespace Neo\PicpayDesafioBackend\Command;

use Neo\PicpayDesafioBackend\Infra\ContainerDependency;

interface InterfaceCommand
{
    public static function execute(ContainerDependency $container, array $args): void;
}
