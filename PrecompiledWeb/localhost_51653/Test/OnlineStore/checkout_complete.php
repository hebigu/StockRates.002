<?php

    // Connect to the MySQL database  
    include "storescripts/connect_to_mysql.php"; 

    


    if ($_SERVER['REQUEST_METHOD'] != "POST") die ("No Post Variables");
    // Initialize the $req variable and add CMD key value pair
    $req = 'cmd=_notify-validate';
    // Read the post from PayPal
    foreach ($_POST as $key => $value) {
        $value = urlencode(stripslashes($value));
        $req .= "&$key=$value";
    }
    
    $req = str_replace("&", "\n", $req);  // Make it a nice list in case we want to email it to ourselves for reporting
      
    $product_id_string = $_POST['custom'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address_street = $_POST['address_street'];
    $address_city = $_POST['address_city'];
    $address_zip = $_POST['address_zip'];
    $address_country = $_POST['address_country'];
    $address_state = $_POST['address_state'];
    $txn_id = $_POST['txn_id'];
    $email = $_POST['business'];
    $contact_phone = $_POST['contact_phone'];
    
    $mc_shipping = money_format("%10.0n", $_POST['mc_shipping']);
    $mc_gross =  money_format("%10.0n", $_POST['mc_gross']);
    $vatTotal = money_format("%10.2n",($mc_gross)/125*25);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Ordrebekr&aeligftelse</title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<body>
<div align="center" id="mainWrapper">
  <?php include_once("template_header.php");?>
    
   <div id="pageContent">
    <div style="margin:24px; text-align:left;">
	
    <?php
       $sql = mysql_query("SELECT * FROM transactions WHERE txn_id='$txn_id' LIMIT 1");
   		while ($row = mysql_fetch_array($sql)) {
			$orderNumber = $row["id"];
		}
    
    echo '<div align=center><strong><font size="5">Ordrebekr&aeligftelse ordrenr. '.$orderNumber.'</font></strong></div>'; 
    
    ?>
    
    <br />
    
   <table width="100%" border="2" cellspacing="5" cellpadding="6">
      <tr>
        <table width="100%" border="2" cellspacing="0" cellpadding="2">
           <tr>
               <td align=left width="50%" bgcolor="#C5DFFA"><strong>Faktureringsinformation</strong></td>
               <td align=left width="50%" bgcolor="#C5DFFA"><strong>Betalingsmetode</strong></td>
           </tr>
       </table>
       <table width="100%" border="1" cellspacing="1" cellpadding="4">
          <tr>
                 <?php echo '<td align=left width="50%" bgcolor="#C5DFFG">'.$first_name.' '.$last_name.'.'
                         . '<div>'.$address_street.'</div>'
                         . '<div>'.$address_zip.' '.$address_city.'</div>'
                         . '<div>'.$address_country.'</div>'
                         . '</td>'; ?>
               <td align=left width="50%" bgcolor="#C5DFFG">Paypal</td>
          </tr>
       </table>
              

        <table width="100%" border="2" cellspacing="0" cellpadding="2">
           <tr>
               <td align=left width="50%" bgcolor="#C5DFFA"><strong>Leveringsinformation</strong></td>
               <td align=left width="50%" bgcolor="#C5DFFA"><strong>Leveringsmetode</strong></td>
           </tr>
       </table>
       <table width="100%" border="1" cellspacing="1" cellpadding="4">
          <tr>
               <td align=left width="50%" bgcolor="#C5DFFG">Samme adresse som faktureringsadresse</td>
               <td align=left width="50%" bgcolor="#C5DFFG">Post Danmark eller andet</td>
          </tr>
       </table>     
      </tr>
   </table>
    
   <br />
    
   <table width="100%" border="1" cellspacing="0" cellpadding="6">
      <tr>
        <td  width="75%" bgcolor="#C5DFFA"><strong>Produkt</strong></td>
        <td  align=right width="8%" bgcolor="#C5DFFA"><strong>Antal</strong></td>
        <td  align=right width=17%" bgcolor="#C5DFFA"><strong>Subtotal DKK</strong></td>
      </tr>
    
   </table>
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
  <?php

        $subtotal = 0;
      
        $id_str_array = explode(",", $product_id_string); // Uses Comma(,) as delimiter(break point)
        
   foreach ($id_str_array as $key => $value) {
    
	$id_quantity_pair = explode("-", $value); // Uses Hyphen(-) as delimiter to separate product ID from its quantity
	$product_id = $id_quantity_pair[0]; // Get the product ID
	$product_quantity = $id_quantity_pair[1]; // Get the quantity     
        
        
        if (isset($product_quantity))
        {
                $sql = mysql_query("SELECT * FROM products WHERE id='$product_id' LIMIT 1");
		while ($row = mysql_fetch_array($sql)) {
			$product_name = $row["product_name"];
			$price =  $row["price"];
			$details =  $row["details"];  
                        
                        $rowprice = $price * $product_quantity;
                        $subtotal = $subtotal + $rowprice;
		}
                
            
            $order = '<tr>';
            $order .= '<td width="75%">'.$product_name.' &nbsp;</td>';
            $order .= '<td align=right width="8%">'.$product_quantity.' &nbsp;</td>';
            $order .= '<td align=right width="17%">'.$rowprice.' &nbsp;</td>';
            $order .= '</tr>';

            echo $order;
        }
   }
   

   
   
   
  ?>
  </table>
   <table width="100%" border="1" cellspacing="0" cellpadding="0">
 <?php   

        $orderFooter .= '<tr>';
        $orderFooter .= '<td width="83%" bgcolor="#C5DFFG">Subtotal&nbsp;</td>';
        $orderFooter .= '<td align=right width="17%" bgcolor="#C5DFFG">'.$subtotal.' &nbsp;</td>';
        $orderFooter .= '</tr>';

        $orderFooter .= '<tr>';
        $orderFooter .= '<td width="83%" bgcolor="#C5DFFG">Forsendelse og h&aringndtering&nbsp;</td>';
        $orderFooter .= '<td align=right width="17%" bgcolor="#C5DFFG">'.$mc_shipping.' &nbsp;</td>';
        $orderFooter .= '</tr>';
        
        $orderFooter .= '<tr>';
        $orderFooter .= '<td width="83%" bgcolor="#C5DFFG"><strong>Total pris inkl. forsendelse og moms&nbsp;</strong></td>';
        $orderFooter .= '<td align=right width="17%" bgcolor="#C5DFFG"><strong>'.$mc_gross.' &nbsp;</strong></td>';
        $orderFooter .= '</tr>';
        
        $orderFooter .= '<tr>';
        $orderFooter .= '<td width="83%" bgcolor="#C5DFFG">Heraf moms&nbsp;</td>';
        $orderFooter .= '<td align=right width="17%" bgcolor="#C5DFFG">'.$vatTotal.' &nbsp;</td>';
        $orderFooter .= '</tr>';
        
        echo $orderFooter;
        
        unset($_SESSION["cart_array"]);
  ?>  
   </table>
    </div>
   <br />
  </div>
    

<?php 
        include_once("template_footer.php");
        include "testPDF.php"; 


        


//// Instantiation of inherited class
//$pdf = new PDF();
//$logoPath = 'style/logo.jpg';
//$logoLeft = 10;
//$logoDown = 2;
//$logoSize = 60;
//
//$title = iconv("UTF-8", "ISO-8859-1", "Ordrebekræftelse" . " - Ordrenr. " . $orderNumber);
//$titleHeight = 9;
//$titleBorder = 1;
//$pdf->SetTitle($title);
//
//$customerName = $first_name.' '.$last_name;
//
//
//        $customerKey =  "Navn \n";
//        $customerKey .= "Vejnavn \n";
//        $customerKey .= "Postnr./by \n";
//        $customerKey .= "Land \n";
//        $customerKey .= "Telefon \n";
//        $customerKey .= "E-mail \n";
//
//
//        $customerInformation =  $customerName."\n";
//        $customerInformation .= $address_street."\n";
//        $customerInformation .= $address_zip." ".$address_city."\n";
//        $customerInformation .= $address_country."\n";
//        $customerInformation .= $contact_phone."\n";
//        $customerInformation .= $email."\n";
//
//
//        $orderKeys =  "Kundenummer \n";
//        $orderKeys .= "Ordrenr. \n";
//        $orderKeys .= "Betaling \n";
//        $orderKeys .= "Sælger \n";
//        $orderKeys .= "Vores Ref. \n";
//        $orderKeys .= "Deres Ref. \n";
//
//
//        $orderInformation = "- \n";
//        $orderInformation .= $orderNumber."\n";
//        $orderInformation .= "Via Paypal \n";
//        $orderInformation .= "Henrik Bigum \n";
//        $orderInformation .= "Henrik Bigum \n";
//        $orderInformation .= $customerName."\n";
//
//        //$orders="8-1,9-1";
//        
//        $orders = $product_id_string;
//        
//        $pdf->PrintChapter($customerName, $orderNumber, $customerKey, $customerInformation, $orderKeys, $orderInformation, $orders, $mc_shipping, $mc_gross, $vatTotal);
//
//        $attachment = 'saved_documents/Order_'.$orderNumber.'.pdf';
//        
//        $pdf->Output($attachment, 'F');
//        
//      
        
//        //Send ordrebekræftelse via mail til kunde
//        require_once("PHPMailer-master/class.phpmailer.php");
//        $to = $email;
//        $subj = $title;
//                //'Ordrebekæftelse på ordrenummer '.$orderNumber;
//        $message =  "Kære kunde \n\n";
//        $message .= "BigumSoft takker for ordren.\n\n";
//        $message .= "Vi har vedlagt ordrebekræftelsen som bilag.\n\n";
//        $message .= "Med venlig hilsen\n\n";
//        $message .= "BigumSoft v/Henrik Bigum";
//        $message = iconv("UTF-8", "ISO-8859-1",$message);
//        $from = 'okij@sol.dk';
//        
//                     
//        
//        $mail = new PHPMailer();
//        
//        
//        
//        $mail->From = $from;
//        $mail->FromName = "BigumSoft v./Henrik Bigum";
//        
//        
//        
//        $mail->Subject = $subj;
//        
//       
//        
//        $mail->Body = $message;
//        
//         
//        
//        $mail->addAddress($to);
//        
//        $mail->addAttachment($attachment);
//
//        if(!$mail->Send())
//        {
//            echo  $mail->ErrorInfo;
//               
//            
//        }
//        else 
//        {
//           // echo '<div align=center><strong><font size="5">Mail sent</font></strong></div>';
//        }
//        
//        ?>
    
</div>
</body>
</html>