<?php

use entity\ParserOutput\ParserOutput;
use services\FileBytesSplitterService\FileBytesSplitterService;
use services\OutputService\OutputService;
use services\InputService\InputService;

require_once 'core/init.php';

$inputService = new InputService();
$configService = new ConfigService();

$logFileName = $inputService->getLogFileName();
$threadsNum = $configService->getThreadsNum();
$perThreadBufferSize = $configService->perThreadBufferSize();

var_dump($logFileName);
var_dump($threadsNum);
var_dump($perThreadBufferSize);

//делим файл на участки для потоков
$fileSplitterService = new FileBytesSplitterService($threadsNum);
$threadsRanges = $fileSplitterService->splitFile($logFileName);
var_dump($threadsRanges);
//обрабатываем участки потоками


//$result = new ParserOutput();
//$result->setCrawlers(["Google" => 123, "Yandex" => 33]);
//$result->setStatusCodes(["200" => 2, "303" => 4, "404" => 1]);
//$result->setTraffic(10000);
//$result->setUrls(300);
//$result->setViews(4124);
//
//$outputService = new OutputService($result);
//echo $outputService->getResponse();