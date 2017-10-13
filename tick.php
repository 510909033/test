<?php

declare(ticks=2);

// A function called on each tick event
function tick_handler()
{
    echo "tick_handler() called\n";
}

function tick_handler2()
{
    echo "tick_handler2() called\n";
}

echo '0000'."\n";
register_tick_function('tick_handler');
echo '1111'."\n";
// register_tick_function('tick_handler2');
// echo '2222'."\n";

$a = 1;

if ($a > 0) {
    $a += 2;
    print($a);
}