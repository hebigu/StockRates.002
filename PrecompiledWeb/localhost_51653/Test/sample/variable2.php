<?php
$x=5; // global scope

function myTest()
{
echo $x; // local scope
}

myTest();
?>