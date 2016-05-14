<?php

function add_numbers($a, $b){
    $sum= 0;
    $sum= $a + $b;
    return $sum;
}

$total= 0;
$total= add_numbers(2, 3);
print("Total is: $total");
