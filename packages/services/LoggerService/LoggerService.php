<?php

namespace services\LoggerService;

class LoggerService {
    private static string $logFileName = 'parser.log';
    
    static function log(string $content)
    {
        file_put_contents(
            LoggerService::$logFileName, 
            (new \DateTime())->format('Y-m-d H:i:s') . '  ' . $content . PHP_EOL,
            FILE_APPEND
        );
    }
}