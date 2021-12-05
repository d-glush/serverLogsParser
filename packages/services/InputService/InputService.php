<?php

namespace services\InputService;

use entity\ParserInput\ParserInput;
use UnexpectedValueException;

class InputService {
    private ParserInput $inputData;

    public function __construct()
    {
        global $argv;
        $inputLogsFileName = $argv[1];
        if (!is_readable($inputLogsFileName)) {
            throw new UnexpectedValueException('');
        }
        $this->inputData = new ParserInput($inputLogsFileName);
    }

    public function getLogFileName(): string {
        return $this->inputData->getLogsFileName();
    }
}