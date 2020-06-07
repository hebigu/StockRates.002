<?php

// Check to see there are posted variables coming into the script
if ($_SERVER['REQUEST_METHOD'] != "POST") die ("No Post Variables");
// Initialize the $req variable and add CMD key value pair
$req = 'cmd=_notify-validate';
// Read the post from PayPal
foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}
// Now Post all of that back to PayPal's server using curl, and validate everything with PayPal
// We will use CURL instead of PHP for this for a more universally operable script (fsockopen has issues on some environments)
//$url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
//$url = "https://www.paypal.com/cgi-bin/webscr";
$url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
$curl_result=$curl_err='';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
curl_setopt($ch, CURLOPT_HEADER , 0);   
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$curl_result = @curl_exec($ch);
$curl_err = curl_error($ch);
curl_close($ch);

$req = str_replace("&", "\n", $req);  // Make it a nice list in case we want to email it to ourselves for reporting

// Check that the result verifies
if (strpos($curl_result, "VERIFIED") !== false) {
    $req .= "\n\nPaypal Verified OK";
} else {
	$req .= "\n\nData NOT verified from Paypal!";
	mail("hebigu@gmail.com", "IPN interaction not verified", "$req", "From: hbigum@yahoo.dk" );
	exit();
}

/* CHECK THESE 4 THINGS BEFORE PROCESSING THE TRANSACTION, HANDLE THEM AS YOU WISH
1. Make sure that business email returned is your business email
2. Make sure that the transaction�s payment status is �completed�
3. Make sure there are no duplicate txn_id
4. Make sure the payment amount matches what you charge for items. (Defeat Price-Jacking) */
 
// Check Number 1 ------------------------------------------------------------------------------------------------------------
$receiver_email = $_POST['receiver_email'];
if ($receiver_email != "hebigu@gmail.com") {
	$message = "Investigate why and how receiver email is wrong. Email = " . $_POST['receiver_email'] . "\n\n\n$req";
    mail("hebigu@gmail.com", "Receiver Email is incorrect", $message, "From: hbigum@yahoo.dk" );
    exit(); // exit script
}
// Check number 2 ------------------------------------------------------------------------------------------------------------
if ($_POST['payment_status'] != "Completed") {
	// Handle how you think you should if a payment is not complete yet, a few scenarios can cause a transaction to be incomplete
}
// Connect to database ------------------------------------------------------------------------------------------------------
require_once 'connect_to_mysql.php';
// Check number 3 ------------------------------------------------------------------------------------------------------------
$this_txn = $_POST['txn_id'];
$control = mysql_query("SELECT id FROM transactions WHERE txn_id='$this_txn' LIMIT 1");
$numRows = mysql_num_rows($control);
if ($numRows > 0) {
    $message = "Duplicate transaction ID occured so we killed the IPN script. \n\n\n$req";
    mail("hebigu@gmail.com", "Duplicate txn_id in the IPN system", $message, "From: hbigum@yahoo.dk" );
    exit(); // exit script
} 
// Check number 4 ------------------------------------------------------------------------------------------------------------
$product_id_string = $_POST['custom'];
$product_id_string = rtrim($product_id_string, ","); // remove last comma
// Explode the string, make it an array, then query all the prices out, add them up, and make sure they match the payment_gross amount
$id_str_array = explode(",", $product_id_string); // Uses Comma(,) as delimiter(break point)
$fullAmount = 0;




foreach ($id_str_array as $key => $value) {
    
	$id_quantity_pair = explode("-", $value); // Uses Hyphen(-) as delimiter to separate product ID from its quantity
	$product_id = $id_quantity_pair[0]; // Get the product ID
	$product_quantity = $id_quantity_pair[1]; // Get the quantity
	$sql = mysql_query("SELECT price FROM products WHERE id='$product_id' LIMIT 1");
    while($row = mysql_fetch_array($sql)){
		$product_price = $row["price"];
	}
       
	$product_price = $product_price * $product_quantity;
	$fullAmount = $fullAmount + $product_price;
              
     
}
$fullAmount = number_format($fullAmount, 2);
$grossAmount = $_POST['mc_gross']; 

$shipment = $_POST['mc_shipping']; 

$fullAmountMinusShipment = $grossAmount - $shipment;


if ($fullAmount != $fullAmountMinusShipment) {
        $message = "Possible Price Jack: " . $_POST['payment_gross'] . " != $fullAmount \n\n\n$req";
        mail("hebigu@gmail.com", "Price Jack or Bad Programming", $message, "From: hbigum@yahoo.dk" );
        exit(); // exit script
} 
// END ALL SECURITY CHECKS NOW IN THE DATABASE IT GOES ------------------------------------
////////////////////////////////////////////////////


//Stock update - a better way maybe had to be introduced 
foreach ($id_str_array as $key => $value) {
    
	$id_quantity_pair = explode("-", $value); // Uses Hyphen(-) as delimiter to separate product ID from its quantity
	$product_id = $id_quantity_pair[0]; // Get the product ID
	$product_quantity = $id_quantity_pair[1]; // Get the quantity
	        
        //Adjust the stock quantity
        $sql = mysql_query("UPDATE products SET on_stock = on_stock - '$product_quantity' WHERE id='$product_id'");
    
}




$custom = $_POST['custom'];
$payer_email = $_POST['payer_email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$payment_date = $_POST['payment_date'];
$mc_gross = $_POST['mc_gross'];
if (isset($_POST['payment_currency']))
{
    $payment_currency = $_POST['payment_currency'];
}
 else 
{
     $payment_currency = 'DKK';
}
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payment_type = $_POST['payment_type'];
$payment_status = $_POST['payment_status'];
$txn_type = $_POST['txn_type'];
$payer_status = $_POST['payer_status'];
$address_street = $_POST['address_street'];
$address_city = $_POST['address_city'];
$address_state = $_POST['address_state'];
$address_zip = $_POST['address_zip'];
$address_country = $_POST['address_country'];
$address_status = $_POST['address_status'];
$notify_version = $_POST['notify_version'];
$verify_sign = $_POST['verify_sign'];
$payer_id = $_POST['payer_id'];
$mc_currency = $_POST['mc_currency'];
if (isset($_POST['mc_fee']))
{
    $mc_fee = $_POST['mc_fee'];
}
 else 
{
     $mc_fee = 0;
}
$vatTotal = money_format("%10.2n",($mc_gross)/125*25);

// Place the transaction into the database
$sql = mysql_query("INSERT INTO transactions (product_id_array, payer_email, first_name, last_name, payment_date, mc_gross, payment_currency, txn_id, receiver_email, payment_type, payment_status, txn_type, payer_status, address_street, address_city, address_state, address_zip, address_country, address_status, notify_version, verify_sign, payer_id, mc_currency, mc_fee, mc_shipping, vat) 
   VALUES('$custom','$payer_email','$first_name','$last_name','$payment_date','$mc_gross','$payment_currency','$txn_id','$receiver_email','$payment_type','$payment_status','$txn_type','$payer_status','$address_street','$address_city','$address_state','$address_zip','$address_country','$address_status','$notify_version','$verify_sign','$payer_id','$mc_currency','$mc_fee', '$shipment', '$vatTotal')") or die ("unable to execute the query");

mysql_close();
// Mail yourself the details
mail("hebigu@gmail.com", "NORMAL IPN RESULT YAY MONEY!", $req, "From: hbigum@yahoo.dk");


//Herfra nyt

include "do_PDF.php"; 

// Instantiation of inherited class
$pdf = new PDF();
$logoPath = '../style/logo.jpg';
$logoLeft = 10;
$logoDown = 2;
$logoSize = 60;

       $sql = mysql_query("SELECT * FROM transactions WHERE txn_id='$this_txn' LIMIT 1");
   		while ($row = mysql_fetch_array($sql)) {
			$orderNumber = $row["id"];
		}


$title = iconv("UTF-8", "ISO-8859-1", "Ordrebekræftelse" . " - Ordrenr. " . $orderNumber);
$titleHeight = 9;
$titleBorder = 1;
$pdf->SetTitle($title);




$customerName = $first_name.' '.$last_name;

$customerKey =  "Navn \n";
$customerKey .= "Vejnavn \n";
$customerKey .= "Postnr./by \n";
$customerKey .= "Land \n";
$customerKey .= "Telefon \n";
$customerKey .= "E-mail \n";


$customerInformation =  iconv("UTF-8", "ISO-8859-1",$customerName)."\n";
$customerInformation .= iconv("UTF-8", "ISO-8859-1",$address_street)."\n";
$customerInformation .= $address_zip." ".$address_city."\n";
$customerInformation .= $address_country."\n";
$customerInformation .= $contact_phone."\n";
$customerInformation .= $payer_email."\n";

$orderKeys .= "Ordrenr. \n";
$orderKeys .= "Betaling \n";
$orderKeys .= "Sælger \n";
$orderKeys .= "Vores Ref. \n";
$orderKeys .= "Deres Ref. \n";

$orderInformation = $orderNumber."\n";
$orderInformation .= "Via Paypal \n";
$orderInformation .= "Henrik Bigum \n";
$orderInformation .= "Henrik Bigum \n";
$orderInformation .= $customerName."\n";

        //$orders="8-1,9-1";       
$orders = $product_id_string;
 

$pdf->PrintChapter($customerName, $orderNumber, $customerKey, $customerInformation, $orderKeys, $orderInformation, $orders, $mc_shipping, $mc_gross, $vatTotal);

//$attachment = '../saved_documents/Order_'.$orderNumber.'.pdf';
$attachment = '/media/usbdisk1/Bigumsoft/saved_documents/Order_'.$orderNumber.'.pdf';
        
$pdf->Output($attachment, 'F');

        
        //Send ordrebekræftelse via mail til kunde
        require_once("../PHPMailer-master/class.phpmailer.php");
        $to = $payer_email;
        $subj = $title;

        $message =  "Kære kunde \n\n";
        $message .= "BigumSoft takker for ordren.\n\n";
        $message .= "Vi har vedlagt ordrebekræftelsen som bilag.\n\n";
        $message .= "Med venlig hilsen\n\n";
        $message .= "BigumSoft v/Henrik Bigum";
        $message = iconv("UTF-8", "ISO-8859-1",$message);
        $from = 'hbigum@yahoo.dk';
        
                     
        
        $mail = new PHPMailer();
        
//hertil ok     
        
        
        $mail->From = $from;
        $mail->FromName = "BigumSoft v./Henrik Bigum";
        
        
        
        $mail->Subject = $subj;
        
       
        
        $mail->Body = $message;
        
         
        
        $mail->addAddress($to);
        
  
        
        $mail->addAttachment($attachment);

        if(!$mail->Send())
        {
            echo  $mail->ErrorInfo;
               
//            $myFile = "../saved_documents/testFile.txt";
//            $fh = fopen($myFile, 'w') or die("can't open file");
//            $stringData = 'Error '.$mail->ErrorInfo;
//            fwrite($fh, $stringData);
//            fclose($fh);
            
        }
        else 
        {
//            $myFile = "../saved_documents/testFile.txt";
//            $fh = fopen($myFile, 'w') or die("can't open file");
//            $stringData = 'Ok '.$attachment;
//            fwrite($fh, $stringData);
//            fclose($fh);
        }



?>