<?php

namespace Neo\PicpayDesafioBackend\Config;

abstract class LoaderConfig
{
    abstract public function load(): array;
}
