<?php

	$con    = mysqli_connect("localhost", "root", "shroot");  
	// Check connection  
	if (mysqli_connect_errno()) {  
		echo "Failed to connect to MySQL: " . mysqli_connect_error();  
} 

$result = mysqli_query($con, "select distinct StockCode FROM StockRates.StockRatesInventory order by StockCode");  

echo "<form type=get action='StockPortFolio.html'>";

echo "<input type=submit value='Consolidated' name='param' size=10><br>";

while ($row = mysqli_fetch_array($result)) {  
     
	$menuItem = $row["StockCode"];
	 	
	echo "<input type=submit value='$menuItem' name='param' size=10>";
}

echo "</form>"

?>