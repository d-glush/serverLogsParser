<?php

namespace services\FileBytesSplitterService;

class FileBytesSplitterService {
    private int $piecesNum;

    public function __construct(int $rangesNum = 1)
    {
        $this->piecesNum = $rangesNum;
    }

    /**
     * @return array<FilePiece>
     */
    public function splitFile($fileName): array {
        $fileSize = stat($fileName)['size'];
        $fStream = fopen($fileName, 'r');
        $pieces = [];
        $perPieceSize = ceil($fileSize / $this->piecesNum);
        $currPieceEndByte = -1;

        while ($currPieceEndByte + 1 < $fileSize) {
            $currThreadStartByte = $currPieceEndByte + 1;
            $wrongPieceEndByte = $currThreadStartByte + $perPieceSize;
            fseek($fStream, $wrongPieceEndByte);
            fgets($fStream);
            $currPieceEndByte = min(ftell($fStream) - 1, $fileSize - 1);
            $currPiece = new FilePiece($currThreadStartByte, $currPieceEndByte);
            $pieces[] = $currPiece;
        }

        return $pieces;
    }
}