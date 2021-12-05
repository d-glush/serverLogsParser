<?php

namespace  services\OutputService;

use entity\ParserOutput\ParserOutput;

class OutputService {
    private ParserOutput $outputData;

    public function __construct($outputData)
    {
        $this->outputData = $outputData;
    }

    public function getResponse(): string {
        return $this->convertDataToJson();
    }

    private function convertDataToJson(): string {
        return json_encode($this->outputData, JSON_PRETTY_PRINT);
    }
}