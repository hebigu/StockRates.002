<?php
$x=5; // global scope
$y=10; // global scope

function myTest()
{
global $x,$y;
$y=$x+$y;
}

myTest();
echo $y; // outputs 15
?> 