<?php

function even_or_odd(int $n): string {

    if( $n % 2 == 0)
        return "Even";
    else
        return "Odd";
}

$n = 2;
echo even_or_odd($n);