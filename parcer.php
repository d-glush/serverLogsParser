<?php

use entity\ParserOutput\ParserOutput;
use services\FileBytesSplitterService\FileBytesSplitterService;
use services\OutputService\OutputService;
use services\InputService\InputService;
use services\ThreadService\ThreadService;

require_once 'core/init.php';

$inputService = new InputService();
$configService = new ConfigService();
$logFileName = $inputService->getLogFileName();
$threadsNum = $configService->getThreadsNum();
$perThreadBufferSize = $configService->perThreadBufferSize();

//делим файл на участки для потоков
$fileSplitterService = new FileBytesSplitterService($threadsNum);
$threadsRanges = $fileSplitterService->splitFile($logFileName);
//var_dump($threadsRanges);

//обрабатываем участки потоками
$threadService = new ThreadService($threadsNum);
foreach ($threadsRanges as $threadRange) {
    $currThreadEndByte = $threadRange->getEndByte();
    $currThreadStartByte = $threadRange->getStartByte();
    $command = "php -f .\subProc.php $logFileName $currThreadStartByte $currThreadEndByte";
    $threadService->addCommandThread($command);
}

//запускаем потоки
$threadService->startThreads();
//ожидаем исполнения
while (!$threadService->isAllThreadsDone()) {
    usleep(250000);
}

//вытаскиваем результаты
$results = $threadService->getThreadsOutput();
var_dump($results);

//суммируем результаты


//$result = new ParserOutput();
//$result->setCrawlers(["Google" => 123, "Yandex" => 33]);
//$result->setStatusCodes(["200" => 2, "303" => 4, "404" => 1]);
//$result->setTraffic(10000);
//$result->setUrls(300);
//$result->setViews(4124);
//
//$outputService = new OutputService($result);
//echo $outputService->getResponse();