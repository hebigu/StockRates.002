<?php

$stockCode = isset($_GET['param']) ? $_GET['param'] : null;

$x_axis = array();  
$y_axis = array();  
$i      = 0;  
$con    = mysqli_connect("localhost", "root", "shroot");  
// Check connection  
if (mysqli_connect_errno()) {  
    echo "Failed to connect to MySQL: " . mysqli_connect_error();  
}  

if ($stockCode === 'konsolideret')
{
	$result = mysqli_query($con, "select Sum(Number) from StockRates.StockRatesInventory group by BatchNo desc Limit 1");  
}
else
{
	$result = mysqli_query($con, "select Number from StockRates.StockRatesInventory where StockCode = '$stockCode' order by BatchNo desc Limit 1");  
}

mysqli_close($con);  

return result;

?>