<?php

use entity\ParserOutput\ParserOutput;
use services\OutputService\OutputService;
use services\InputService\InputService;

require_once 'core/init.php';

$inputService = new InputService();
$logFileName = $inputService->getLogFileName();


$result = new ParserOutput();
$result->setCrawlers(["Google" => 123, "Yandex" => 33]);
$result->setStatusCodes(["200" => 2, "303" => 4, "404" => 1]);
$result->setTraffic(10000);
$result->setUrls(300);
$result->setViews(4124);


$outputService = new OutputService($result);
echo $outputService->getResponse();