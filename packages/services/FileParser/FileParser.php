<?php

namespace services\FileParser;

use entity\ParserOutput\ParserOutput;
use entity\ParserOutput\SubParserOutput;
use InvalidArgumentException;
use mysql_xdevapi\Exception;
use services\FileParser\ParsedLog;
use services\LoggerService\LoggerService;

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

    public function parse(string $fileName, int $startByte, int $endByte): SubParserOutput {
        $result = new SubParserOutput();
        $fStream = fopen($fileName, 'r');
        fseek($fStream, $startByte);
        $views = 0;
        $uniqueUrls = [];
        $traffic = 0;
        $crawlers = array_fill_keys(FileParser::$crawlersList, 0);
        $statusCodes = [];

        while ((ftell($fStream) < $endByte) && ($bufferString = fgets($fStream))) {
            try {
                $parsedLog = $this->parseLog($bufferString);
            } catch (InvalidArgumentException $e) {
                LoggerService::log(" !!!!! PARSE ERROR --- $bufferString");
                continue;
            }
            $views++;
            $uniqueUrls[$parsedLog->getUrl()] = true;
            if ($parsedLog->getResponseCode() !== 301) {
                $traffic += $parsedLog->getResponseSize();
            }
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
            ->setUrls(count($uniqueUrls))
            ->setTraffic($traffic)
            ->setCrawlers($crawlers)
            ->setStatusCodes($statusCodes)
            ->setUniqueUrls($uniqueUrls);
        return $result;
    }

    private function parseLog(string $logString): ParsedLog
    {
        $preg = '/(.*) - - \[(.*)\] "(.*)" (\d+) (\d+) "(.*)" "(.*)"/u';
        preg_match($preg, $logString, $matches);

        if (!isset(
            $matches[1],
            $matches[2],
            $matches[3],
            $matches[4],
            $matches[5],
            $matches[6],
            $matches[7]
        )) {
            throw new InvalidArgumentException();
        }
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