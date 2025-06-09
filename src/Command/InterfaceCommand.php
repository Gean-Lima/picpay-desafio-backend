<?php

namespace Neo\PicpayDesafioBackend\Command;

interface InterfaceCommand
{
    public static function execute(array $args): void;
}
