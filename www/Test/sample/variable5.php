<!DOCTYPE html>
<html>
<body>

<?php

function myTest()
{
static $x=0;
echo $x;
$x++;
}

myTest();
myTest();
myTest();

?> 

</body>
</html>