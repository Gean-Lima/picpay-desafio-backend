<?php

use Neo\PicpayDesafioBackend\Infra\ContainerDependency;

if (!function_exists('container')) {
    function container(?ContainerDependency $set = null): ContainerDependency
    {
        static $container;

        if ($set) {
            $container = $set;
        }

        return $container;
    }
}
