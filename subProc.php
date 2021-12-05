<?php

use services\FileParser\FileParser;
use services\OutputService\OutputService;

require_once 'core/init.php';

$fileName = $argv[1];
$startByte = (int)$argv[2];
$endByte = (int)$argv[3];

$fileParser = new FileParser();
$result = $fileParser->parse($fileName, $startByte, $endByte);

$outputService = new OutputService($result);
echo $outputService->getResponse();