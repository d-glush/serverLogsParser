<?php

Class ConfigService
{
    private ?array $config = null;

    public function __construct(string $configPath = __DIR__ . '\..\config.php')
    {
        $this->config = include $configPath;
    }

    public function getAutoloaderPriorities(): array
    {
        return $this->config['autoloaderPriorities'];
    }

    public function getGameComplexities(): array
    {
        return $this->config['gameComplexities'];
    }

    public function getLogsPaths(): array
    {
        return $this->config['logs'];
    }
}