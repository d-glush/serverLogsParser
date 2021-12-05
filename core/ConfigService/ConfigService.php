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

    public function getThreadsNum(): int
    {
        return $this->config['threadsNum'] ?? 1;
    }

    public function perThreadBufferSize(): int
    {
        return $this->config['preThreadBufferSize'] ?? 1;
    }

    public function getCrawlersList(): array
    {
        return $this->config['crawlersList'] ?? [];
    }
}