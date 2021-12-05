<?php

namespace services\FileBytesSplitterService;

class FilePiece {
    private int $startByte;
    private int $endByte;

    public function __construct(int $startByte, int $endByte)
    {
        $this->startByte = $startByte;
        $this->endByte = $endByte;
    }

    public function getStartByte(): int
    {
        return $this->startByte;
    }

    public function setStartByte(int $startByte): self
    {
        $this->startByte = $startByte;
        return $this;
    }

    public function getEndByte(): int
    {
        return $this->endByte;
    }

    public function setEndByte(int $endByte): self
    {
        $this->endByte = $endByte;
        return $this;
    }
}