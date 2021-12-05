<?php

namespace entity\ParserOutput;

class SubParserOutput extends ParserOutput {
    public array $uniqueUrls = [];

    public function getUniqueUrls(): array
    {
        return $this->uniqueUrls;
    }

    public function setUniqueUrls(array $uniqueUrls): self
    {
        $this->uniqueUrls = $uniqueUrls;
        return $this;
    }

    public function setDataByJson(string $json): self
    {
        $decodedJson = json_decode($json);

        $this->views = $decodedJson->views;
        $this->traffic = $decodedJson->traffic;
        $this->urls = $decodedJson->urls;

        foreach ($decodedJson->crawlers as $crawler => $visitCount) {
            $this->crawlers[$crawler] = $visitCount;
        }
        foreach ($decodedJson->statusCodes as $statusCode => $statusCodeCount) {
            $this->statusCodes[$statusCode] = $statusCodeCount;
        }
        foreach ($decodedJson->uniqueUrls as $uniqueUrl => $isVisited) {
            $this->uniqueUrls[$uniqueUrl] = true;
        }

        return $this;
    }

    public function add(SubParserOutput $anotherData) {
        $this->views += $anotherData->getViews();
        $this->traffic += $anotherData->getTraffic();

        $this->uniqueUrls = array_merge($this->uniqueUrls, $anotherData->getUniqueUrls());
        $this->urls = count($this->uniqueUrls);

        $anotherCrawlers = $anotherData->getCrawlers();
        foreach ($anotherCrawlers as $crawler => $crawlerVisits) {
            if (!isset($this->crawlers[$crawler])) {
                $this->crawlers[$crawler] = 0;
            }
            $this->crawlers[$crawler] += $crawlerVisits;
        }

        $anotherStatusCodes = $anotherData->getStatusCodes();
        foreach ($anotherStatusCodes as $statusCode => $statusCodeCount) {
            if (!isset($this->statusCodes[$statusCode])) {
                $this->statusCodes[$statusCode] = 0;
            }
            $this->statusCodes[$statusCode] += $statusCodeCount;
        }
    }
}