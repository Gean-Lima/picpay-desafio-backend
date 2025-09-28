<?php

use Neo\PicpayDesafioBackend\Config\Config;
use Neo\PicpayDesafioBackend\Config\LoaderConfig;
use Neo\PicpayDesafioBackend\Test\TestCase;

class ConfigTest extends TestCase
{
    private Config $config;

    protected function setUp(): void
    {
        parent::setUp();

        $loaderConfig = $this->createMock(LoaderConfig::class);
        $loaderConfig->method('load')->willReturn([
            'test.config' => '1',
        ]);

        $this->config = new Config($loaderConfig);
    }

    public function testGetOptionFromConfig(): void
    {
        $testConfig = $this->config->get('test.config');

        $this->assertEquals('1', $testConfig);
    }

    public function testReturnExceptionIfKeyNotExist()
    {
        $key = 'test';

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Config key '{$key}' not found.");

        $this->config->get($key);
    }
}
