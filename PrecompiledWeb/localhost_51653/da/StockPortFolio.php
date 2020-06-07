<?php

require_once ('../jpgraph/jpgraph-4.0.2/src/jpgraph.php');
require_once ('../jpgraph/jpgraph-4.0.2/src/jpgraph_line.php');
require_once ('../jpgraph/jpgraph-4.0.2/src/jpgraph_bar.php'); 
require_once ('../jpgraph/jpgraph-4.0.2/src/jpgraph_line.php');

$stockCode = isset($_GET['param']) ? $_GET['param'] : null;

$x_axis = array();  
$y_axis = array();  
$i      = 0;  
$stockNumbers = 0; 
$con    = mysqli_connect("localhost", "root", "shroot"); 

// Check connection  
if (mysqli_connect_errno()) {  
    print "Failed to connect to MySQL: " . mysqli_connect_error();  
}  

$CurrentDateTime = mysqli_query($con, "select date(CurrentDateTime) as CurrentDateTime from StockRates.StockRatesInventory order by CurrentDateTime desc limit 1")->fetch_object()->CurrentDateTime;
$WeekAgo = mysqli_query($con, "select date(date_sub(CurrentDateTime, Interval 1 Week)) as WeekAgo from StockRates.StockRatesInventory order by CurrentDateTime desc limit 1")->fetch_object()->WeekAgo;
$MonthAgo = mysqli_query($con, "select date(date_sub(CurrentDateTime, Interval 1 Month)) as MonthAgo from StockRates.StockRatesInventory order by CurrentDateTime desc limit 1")->fetch_object()->MonthAgo;
$YearAgo = mysqli_query($con, "select date(date_sub(CurrentDateTime, Interval 1 Year)) as YearAgo from StockRates.StockRatesInventory order by CurrentDateTime desc limit 1")->fetch_object()->YearAgo;
 
  
if ($stockCode === 'Konsolideret')
{
	$maxBatchNo = mysqli_query($con, "select MAX(BatchNo) as maxBatchNo from StockRates.StockRatesInventory")->fetch_object()->maxBatchNo;
	$minBatchNo = mysqli_query($con, "select MIN(BatchNo) as minBatchNo from StockRates.StockRatesInventory")->fetch_object()->minBatchNo;

	
    $stockNumbers = mysqli_query($con, "select Sum(Number) as numbers from StockRates.StockRatesInventory group by BatchNo desc Limit 1")->fetch_object()->numbers; 
	
	$result = mysqli_query($con, "SELECT DISTINCT CurrentDateTime, SUM(Number * Rate * CurrencyRate) AS ActualValue FROM StockRates.StockRatesInventory GROUP BY BatchNo order by BatchNo asc");  
	
	$stockRate = mysqli_query($con, "select SUM(Number * Rate * CurrencyRate)/SUM(Number) as stockR FROM StockRates.StockRatesInventory where BatchNo = $maxBatchNo")->fetch_object()->stockR;  
	$stockName = "Alle aktier";
	
	$firstDailyStockRate = mysqli_query($con, "SELECT BatchNo, SUM(Number * Rate * CurrencyRate)/$stockNumbers AS firstDailyStockRate FROM StockRates.StockRatesInventory WHERE date(CurrentDateTime) = '$CurrentDateTime' GROUP BY BatchNo ORDER BY BatchNo asc limit 1")->fetch_object()->firstDailyStockRate;	
	
    $weekAgoStockRate = mysqli_query($con, "select BatchNo, SUM(Number * Rate * CurrencyRate)/$stockNumbers AS weekAgoStockRate from StockRates.StockRatesInventory WHERE date(CurrentDateTime) <= '$WeekAgo' GROUP BY BatchNo HAVING SUM(Number * Rate * CurrencyRate)/$stockNumbers > 0 ORDER BY BatchNo DESC limit 1")->fetch_object()->weekAgoStockRate;
	
	$monthAgoStockRate = mysqli_query($con, "select BatchNo, SUM(Number * Rate * CurrencyRate)/$stockNumbers AS monthAgoStockRate from StockRates.StockRatesInventory where date(CurrentDateTime) <= '$MonthAgo' GROUP BY BatchNo HAVING SUM(Number * Rate * CurrencyRate)/$stockNumbers > 0 ORDER BY BatchNo DESC limit 1")->fetch_object()->monthAgoStockRate;
	
	$yearAgoStockRate = mysqli_query($con, "select BatchNo, SUM(Number * Rate * CurrencyRate)/$stockNumbers AS yearAgoStockRate from StockRates.StockRatesInventory where date(CurrentDateTime) <= '$YearAgo' GROUP BY BatchNo HAVING SUM(Number * Rate * CurrencyRate)/$stockNumbers > 0 ORDER BY BatchNo DESC limit 1")->fetch_object()->yearAgoStockRate;
	
    $fromStartAgoStockRate = mysqli_query($con, "select BatchNo, SUM(Number * Rate * CurrencyRate)/$stockNumbers AS fromStartAgoStockRate from StockRates.StockRatesInventory where BatchNo = '$minBatchNo'  GROUP BY BatchNo HAVING SUM(Number * Rate * CurrencyRate)/$stockNumbers > 0 limit 1")->fetch_object()->fromStartAgoStockRate;
		
	$minValueofStocks =  mysqli_query($con, "select BatchNo, SUM(Number * Rate * CurrencyRate)/$stockNumbers AS minValueofStocks from StockRates.StockRatesInventory GROUP BY BatchNo ORDER BY SUM(Number * Rate * CurrencyRate)/$stockNumbers ASC LIMIT 1")->fetch_object()->minValueofStocks;	
	
	$maxValueofStocks =  mysqli_query($con, "select BatchNo, SUM(Number * Rate * CurrencyRate)/$stockNumbers AS maxValueofStocks from StockRates.StockRatesInventory GROUP BY BatchNo ORDER BY SUM(Number * Rate * CurrencyRate)/$stockNumbers DESC LIMIT 1")->fetch_object()->maxValueofStocks;	
		
	$lastDataStored = mysqli_query($con, "select CurrentDateTime AS lastDataStored from StockRates.StockRatesInventory order by CurrentDateTime desc limit 1")->fetch_object()->lastDataStored;
	$firstDataStored = mysqli_query($con, "select CurrentDateTime AS firstDataStored from StockRates.StockRatesInventory order by CurrentDateTime asc limit 1")->fetch_object()->firstDataStored;

}
else
{
	$maxBatchNo = mysqli_query($con, "select MAX(BatchNo) as maxBatchNo from StockRates.StockRatesInventory where StockCode like '$stockCode'")->fetch_object()->maxBatchNo;
	$minBatchNo = mysqli_query($con, "select MIN(BatchNo) as minBatchNo from StockRates.StockRatesInventory where StockCode like '$stockCode'")->fetch_object()->minBatchNo;

	
	$stockNumbers = mysqli_query($con, "select Number as numbers from StockRates.StockRatesInventory where StockCode = '$stockCode' order by BatchNo desc Limit 1")->fetch_object()->numbers;	
	
	$result = mysqli_query($con, "SELECT DISTINCT CurrentDateTime, SUM(Number * Rate * CurrencyRate) AS ActualValue FROM StockRates.StockRatesInventory WHERE StockCode = '$stockCode' GROUP BY BatchNo order by BatchNo asc"); 
	
	$stockRate = mysqli_query($con, "select Rate*CurrencyRate AS stockR from StockRates.StockRatesInventory where StockCode like '$stockCode' order by BatchNo desc limit 1")->fetch_object()->stockR;
	
	$stockName = mysqli_query($con, "select Name AS Name from StockRates.StockDetails where StockCode = '$stockCode' ")->fetch_object()->Name;
	
	$firstDailyStockRate = mysqli_query($con, "select Rate*CurrencyRate AS firstDailyStockRate from StockRates.StockRatesInventory where StockCode like '$stockCode' and date(CurrentDateTime) = '$CurrentDateTime' order by CurrentDateTime asc limit 1")->fetch_object()->firstDailyStockRate;
	
	$weekAgoStockRate = mysqli_query($con, "select Rate * CurrencyRate AS weekAgoStockRate from StockRates.StockRatesInventory where StockCode like '$stockCode' and date(CurrentDateTime) <= '$WeekAgo' AND (Rate * CurrencyRate) > 0 order by CurrentDateTime DESC limit 1")->fetch_object()->weekAgoStockRate;
	
	$monthAgoStockRate = mysqli_query($con, "select Rate * CurrencyRate AS monthAgoStockRate from StockRates.StockRatesInventory where StockCode like '$stockCode' and date(CurrentDateTime) <= '$MonthAgo' AND (Rate * CurrencyRate) > 0 order by CurrentDateTime DESC limit 1")->fetch_object()->monthAgoStockRate;
	
	$yearAgoStockRate = mysqli_query($con, "select Rate * CurrencyRate AS yearAgoStockRate from StockRates.StockRatesInventory where StockCode like '$stockCode' and date(CurrentDateTime) <= '$YearAgo' AND (Rate * CurrencyRate) > 0 order by CurrentDateTime DESC limit 1")->fetch_object()->yearAgoStockRate;
	
	$fromStartAgoStockRate = mysqli_query($con, "select Rate * CurrencyRate AS fromStartAgoStockRate from StockRates.StockRatesInventory where StockCode like '$stockCode' and BatchNo = '$minBatchNo' limit 1")->fetch_object()->fromStartAgoStockRate;
	
	$minValueofStocks =  mysqli_query($con, "select BatchNo, SUM(Number * Rate * CurrencyRate)/$stockNumbers AS minValueofStocks from StockRates.StockRatesInventory where StockCode like '$stockCode' GROUP BY BatchNo ORDER BY SUM(Number * Rate * CurrencyRate)/$stockNumbers ASC LIMIT 1")->fetch_object()->minValueofStocks;	
	
	$maxValueofStocks =  mysqli_query($con, "select BatchNo, SUM(Number * Rate * CurrencyRate)/$stockNumbers AS maxValueofStocks from StockRates.StockRatesInventory where StockCode like '$stockCode' GROUP BY BatchNo ORDER BY SUM(Number * Rate * CurrencyRate)/$stockNumbers DESC LIMIT 1")->fetch_object()->maxValueofStocks;	
	
	
	$lastDataStored = mysqli_query($con, "select CurrentDateTime AS lastDataStored from StockRates.StockRatesInventory where StockCode like '$stockCode' order by CurrentDateTime desc limit 1")->fetch_object()->lastDataStored;
    $firstDataStored = mysqli_query($con, "select CurrentDateTime AS firstDataStored from StockRates.StockRatesInventory where StockCode like '$stockCode' order by CurrentDateTime asc limit 1")->fetch_object()->firstDataStored;
}

$lastFetchTime = mysqli_query($con, "select lastFetchTime AS lastFetchTime from StockRates.LastFetch order by lastFetchTime desc limit 1")->fetch_object()->lastFetchTime;

$dayResult = round($stockNumbers * $stockRate) - round($stockNumbers * $firstDailyStockRate);
$dayResultProcent = round($dayResult * 100 / ($stockNumbers * $firstDailyStockRate),2);
 
$weekResult = round($stockNumbers * $stockRate) - round($stockNumbers * $weekAgoStockRate);
$weekResultProcent = round($weekResult * 100 / ($stockNumbers * $weekAgoStockRate),2);

$monthResult = round($stockNumbers * $stockRate) - round($stockNumbers * $monthAgoStockRate);
$monthResultProcent = round($monthResult * 100 / ($stockNumbers * $monthAgoStockRate),2);

$yearResult = round($stockNumbers * $stockRate) - round($stockNumbers * $yearAgoStockRate);
$yearResultProcent = round($yearResult * 100 / ($stockNumbers * $yearAgoStockRate),2);

$fromStartResult = round($stockNumbers * $stockRate) - round($stockNumbers * $fromStartAgoStockRate);
$fromStartResultProcent = round($fromStartResult * 100 / ($stockNumbers * $fromStartAgoStockRate),2);

$minValue = round($stockNumbers * $minValueofStocks);
$maxValue = round($stockNumbers * $maxValueofStocks);

$minMaxDifference = round($maxValue - $minValue,2);

while ($row = mysqli_fetch_array($result)) {  
    $x_axis[$i] = $row["CurrentDateTime"];  
    $y_axis[$i] = $row["ActualValue"];  
    $i++;  
}  
mysqli_close($con);  

$width  = 950;  
$height = 600;  
$graph  = new Graph($width, $height);  
$graph->SetMargin(50,10,40,120);
$graph->SetScale('textint');  
// $graph->title->Set("Sidste forsøg på hentning: " . $lastFetchTime . " # Sidste data gemt: " . $lastDataStored . " # Første data gemt: " . $firstDataStored . "\nAktiebeholdning for aktie " . $stockName . " # " . $stockCode . " # " . $stockNumbers . " * " . round($stockRate, 2) . " = " . round($stockNumbers * $stockRate)  . "\n# Dag: " . $dayResult . "(" . $dayResultProcent . "%)" . " # Uge: " . $weekResult  . "(" . $weekResultProcent . "%)" . " # Måned: " . $monthResult  . "(" . $monthResultProcent . "%)" . " # År: " . $yearResult . "(" . $yearResultProcent . "%)"   );  
$graph->title->Set("Aktiebeholdning for aktie " . $stockName . " # " . $stockCode . " # " . $stockNumbers . " * " . round($stockRate, 2) . " = " . round($stockNumbers * $stockRate));  

if ($dayResult < 0)	
{
	$graph->subtitle->SetColor('darkred');
}
else
{
	$graph->subtitle->SetColor('darkgreen');
}
$graph->subtitle->Set("Dag: " . $dayResult . "(" . $dayResultProcent . "%)" . " # Uge: " . $weekResult  . "(" . $weekResultProcent . "%)" . " # Måned: " . $monthResult  . "(" . $monthResultProcent . "%)" . " # År: " . $yearResult . "(" . $yearResultProcent . "%)" . " # Fra start: " . $fromStartResult . "(" . $fromStartResultProcent . "%)" . " # Min: " . $minValue . "  # Max: " . $maxValue . " # Max-Min: " . $minMaxDifference);
$graph->subsubtitle->Set("Sidste forsøg på hentning: " . $lastFetchTime . " # Sidste data gemt: " . $lastDataStored . " # Første data gemt: " . $firstDataStored);




$graph->xaxis->title->Set('Aktie dato/tid');  
$graph->xaxis->SetTickLabels($x_axis);  
$graph->xaxis->SetLabelAngle(50);
$graph->xaxis->SetTextLabelInterval(5);
$graph->yaxis->title->Set('Aktuelle værdi'); 

$p1 = new LinePlot($y_axis);
$p1->SetColor("navy");
$graph->Add($p1); 
$graph->Stroke();  

?>