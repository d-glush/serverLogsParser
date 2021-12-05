<?php

function parseString(string $string): array {
    $preg = '/(.*) - - \[(.*)\] "(.*)" (\d+) (\d+) "(.*)" "(.*)"/u';
    preg_match($preg, $string, $matches);
    array_shift($matches);
    return $matches;
}

$fStream = fopen('testFiles/testFile10GB.log', 'r');

$offset = 0;
$length = 10000000;
while($offset < stat('testFiles/testFile10GB.log')['size']){
    file_get_contents(
        'testFiles/testFile10GB.log',
        false,
        null,
        $offset,
        $length,
    );
    $offset+=$length;
}

fclose($fStream);
