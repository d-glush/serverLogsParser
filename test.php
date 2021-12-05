<?php

$fStream = fopen('testFiles/testFile2Strings.log', 'r');

//$string = fgets($fStream);
$char = fgetc($fStream);
$char = fgetc($fStream);
$pos = ftell($fStream);

//var_dump($string);
var_dump($char);
var_dump($pos);