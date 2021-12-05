<?php

use entity\ParserOutput\ParserOutput;
use entity\ParserOutput\SubParserOutput;
use services\FileBytesSplitterService\FileBytesSplitterService;
use services\LoggerService\LoggerService;
use services\OutputService\OutputService;
use services\InputService\InputService;
use services\ThreadService\ThreadService;

require_once 'core/init.php';

$inputService = new InputService();
$configService = new ConfigService();
$logFileName = $inputService->getLogFileName();
if (!file_exists($logFileName)) {
    echo 'Input file not exists!';
    exit(1);
}
$threadsNum = $configService->getThreadsNum();
LoggerService::log("START for $logFileName with $threadsNum threads");

//делим файл на участки для потоков
$fileSplitterService = new FileBytesSplitterService($threadsNum);
$threadsRanges = $fileSplitterService->splitFile($logFileName);

//обрабатываем участки потоками
$threadService = new ThreadService($threadsNum);
foreach ($threadsRanges as $threadRange) {
    $currThreadEndByte = $threadRange->getEndByte();
    $currThreadStartByte = $threadRange->getStartByte();
    $command = "php -f .\subProc.php $logFileName $currThreadStartByte $currThreadEndByte";
    $threadService->addCommandThread($command);
    LoggerService::log("THREAD INIT $command");
}

//запускаем потоки
$threadService->startThreads();
//ожидаем исполнения
while (!$threadService->isAllThreadsDone()) {
    usleep(250000);
}

//вытаскиваем результаты
$results = $threadService->getThreadsOutput();

//суммируем результаты
$summedResult = new SubParserOutput();
foreach ($results as $resultJson) {
    LoggerService::log("RESULT GETTED --- $resultJson");
    $curResult = new SubParserOutput();
    $curResult->setDataByJson($resultJson);
    $summedResult->add($curResult);
}

unset($summedResult->uniqueUrls);

$outputService = new OutputService($summedResult);
echo $outputService->converToJson();
