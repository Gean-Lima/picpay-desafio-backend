<?php

use Neo\PicpayDesafioBackend\Config\Config;
use Neo\PicpayDesafioBackend\Test\TestCase;

class ConfigTest extends TestCase
{
    public function testConfig(): void
    {
        $config = Config::getInstance();

        $testConfig = $config->get('test.config');

        $this->assertEquals('1', $testConfig);
    }
}
