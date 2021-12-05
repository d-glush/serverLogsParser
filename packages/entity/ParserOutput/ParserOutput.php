<?php

namespace entity\ParserOutput;

class ParserOutput {
    public int $views;
    public int $urls;
    public int $traffic;
    public array $crawlers;
    public array $statusCodes;

    public function __construct(
        int $views = 0,
        int $urls = 0,
        int $traffic = 0,
        array $crawlers = [],
        array $statusCodes = []
    ) {
        $this->views = $views;
        $this->urls = $urls;
        $this->traffic = $traffic;
        $this->crawlers = $crawlers;
        $this->statusCodes = $statusCodes;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;
        return $this;
    }

    public function getUrls(): int
    {
        return $this->urls;
    }

    public function setUrls(int $urls): self
    {
        $this->urls = $urls;
        return $this;
    }

    public function getTraffic(): int
    {
        return $this->traffic;
    }

    public function setTraffic(int $traffic): self
    {
        $this->traffic = $traffic;
        return $this;
    }

    public function getCrawlers(): array
    {
        return $this->crawlers;
    }

    public function setCrawlers(array $crawlers): self
    {
        $this->crawlers = $crawlers;
        return $this;
    }

    public function getStatusCodes(): array
    {
        return $this->statusCodes;
    }

    public function setStatusCodes(array $statusCodes): self
    {
        $this->statusCodes = $statusCodes;
        return $this;
    }
}