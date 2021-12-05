<?php

namespace entity\ParserInput;

class ParserInput {
    public string $logsFileName;

    public function __construct(string $logsFileName)
    {
        $this->logsFileName = $logsFileName;
    }

    public function getLogsFileName(): string
    {
        return $this->logsFileName;
    }

    public function setLogsFileName(string $logsFileName): self
    {
        $this->logsFileName = $logsFileName;
        return $this;
    }

}
