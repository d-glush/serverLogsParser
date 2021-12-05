<?php

namespace services\FileParser;

class ParsedLog {
    private string $ip;
    private string $methodData;
    private int $responseCode;
    private int $responseSize;
    private string $referer;
    private string $userAgent;

    public function __construct(
        string $ip,
        string $queryData,
        int $responseCode,
        int $responseSize,
        string $referer,
        string $userAgent
    ) {
        $this->ip = $ip;
        $this->methodData = $queryData;
        $this->responseCode = $responseCode;
        $this->responseSize = $responseSize;
        $this->referer = $referer;
        $this->userAgent = $userAgent;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    public function getMethodData(): string
    {
        return $this->methodData;
    }

    public function setMethodData(string $methodData): self
    {
        $this->methodData = $methodData;
        return $this;
    }

    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    public function setResponseCode(int $responseCode): self
    {
        $this->responseCode = $responseCode;
        return $this;
    }

    public function getResponseSize(): int
    {
        return $this->responseSize;
    }

    public function setResponseSize(int $responseSize): self
    {
        $this->responseSize = $responseSize;
        return $this;
    }

    public function getReferer(): string
    {
        return $this->referer;
    }

    public function setReferer(string $referer): self
    {
        $this->referer = $referer;
        return $this;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function setUserAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    public function getUrl(): string
    {
        $preg = '/\/[^? ]+/u';
        preg_match($preg, $this->methodData, $matches);
        return $matches[0];
    }

    public function isCrawler(): bool
    {
        foreach (FileParser::$crawlersList as $crawlerName) {
            if (stripos($this->userAgent, $crawlerName)) {
                return true;
            }
        }
        return false;
    }

    public function getCrawler(): string
    {
        foreach (FileParser::$crawlersList as $crawlerName) {
            if (stripos($this->userAgent, $crawlerName)) {
                return $crawlerName;
            }
        }
        return false;
    }
}