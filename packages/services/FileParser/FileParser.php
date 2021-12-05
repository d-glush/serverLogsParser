<?php

namespace services\FileParser;

use entity\ParserOutput\ParserOutput;
use services\FileParser\ParsedLog;

class FileParser {
    public static array $crawlersList = [
        'Google',
        'Bing',
        'Baidu',
        'Yandex',
    ];

    public function __construct()
    {
    }

    public function parse(string $fileName, int $startByte, int $endByte): ParserOutput {
        $result = new ParserOutput();
        $fStream = fopen($fileName, 'r');

        $views = 0;
        $visitedUrls = [];
        $traffic = 0;
        $crawlers = array_fill_keys(FileParser::$crawlersList, 0);
        $statusCodes = [];

        while ($bufferString = fgets($fStream)) {
            $parsedLog = $this->parseLog($bufferString);
            $views++;
            $visitedUrls[$parsedLog->getUrl()] = true;
            $traffic += $parsedLog->getResponseSize();
            if ($parsedLog->isCrawler()) {
                $crawler = $parsedLog->getCrawler();
                $crawlers[$crawler]++;
            }
            if (isset($statusCodes[$parsedLog->getResponseCode()])) {
                $statusCodes[$parsedLog->getResponseCode()]++;
            } else {
                $statusCodes[$parsedLog->getResponseCode()] = 1;
            }

        }

        $result->setViews($views)
            ->setUrls(count($visitedUrls))
            ->setTraffic($traffic)
            ->setCrawlers($crawlers)
            ->setStatusCodes($statusCodes);
        return $result;
    }

    private function parseLog(string $logString): ParsedLog
    {
        $preg = '/(.*) - - \[(.*)\] "(.*)" (\d+) (\d+) "(.*)" "(.*)"/u';
        preg_match($preg, $logString, $matches);

        $ip = $matches[1];
        $methodData = $matches[3];
        $responseCode = (int)$matches[4];
        $responseSize = (int)$matches[5];
        $referer = $matches[6];
        $userAgent = $matches[7];

        return (new ParsedLog(
            $ip,
            $methodData,
            $responseCode,
            $responseSize,
            $referer,
            $userAgent
        ));
    }
}