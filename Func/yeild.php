<?php

function xrange($start, $end, $step = 1)
{
    for ($i = $start; $i <= $end; $i += $step) {
        yield $i;
    }
}
foreach (xrange(1, 100) as $num) {
    echo $num, "\n";
}

function logger($fileName)
{
    $fileHandle = fopen($fileName, 'a');
    while (true) { 
        fwrite($fileHandle , yield . "\n");
    }
}
$logger = logger(__DIR__ . '/log');
$logger->send('Foo');
$logger->send('Bar');